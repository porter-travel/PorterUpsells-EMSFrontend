<x-app-layout>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

    <style>

        .fulfilment-panel input{
            width: 0;
            height: 0;
            opacity: 0;
            position: absolute;
        }
        .fulfilment-panel input + label{
            border: 1px solid black;
            width: 30px;
            height: 30px;
            display: block;
            border-radius: 5px
        }

        .fulfilment-panel input + label svg{
            display: none
        }

        .fulfilment-panel input:checked + label{
            background: #D4F6D1;
            position: relative;
        }

        .fulfilment-panel input:checked + label svg{
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .temporary-complete{
            opacity: 0.5;
        }

        .temporary-complete span{
            text-decoration: line-through;
        }

        .no-integration .status-pill{
            display: none;
        }
    </style>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Today's Upsells
            </h2>
        </div>
    </x-slot>
    <div class="py-2 max-w-[700px] mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative mb-6">
                        <ul id="hotelsDropdown"
                            class="bg-yellow border border-black rounded-xl p-2  cursor-pointer">
                            @php $i = 0; @endphp
                            @foreach($hotels as $hotel)
                                <li id="orderTrigger{{$i}}"
                                    data-target="ordersPanel{{$i}}"
                                    class="text-xl pr-6 font-bold @if($i > 0) hidden @else active @endif cursor-pointer">
                                    {{$hotel['name']}}
                                    @if(isset($hotel['orders']['ready']) && count($hotel['orders']['ready']) > 0)
                                        <span class="">
                                            ({{count($hotel['orders']['ready'])}})
                                        </span>
                                    @endif

                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                        <div style="pointer-events: none" class="absolute right-2 top-[19px]">
                            <svg width="14" height="9" viewBox="0 0 14 9" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L7 7L13 0.999999" stroke="black" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <hr>
                    @php $i = 0; @endphp
                    @foreach($hotels as $hotel)
                        <div class="orders-panel  mt-6 {{$hotel['integration'] ?: 'no-integration'}} @if($i > 0) hidden @endif" id="ordersPanel{{$i}}">
                            @if(isset($hotel['orders']['ready']) && count($hotel['orders']['ready']) > 0)
                                <div>
                                    <h2 class="text-lg font-bold mb-6">Ready to be fulfilled:</h2>
                                </div>
                                @foreach($hotel['orders']['ready'] as $order)
                                    @include('admin.partials.fulfilment-panel', ['order' => $order, 'status' => 'ready', 'key' => $key])
                                @endforeach
                            @endif

                            @if(isset($hotel['orders']['pending']) && count($hotel['orders']['pending']) > 0)
                                <div>
                                    <h2 class="text-lg font-bold mb-6">Awaiting assignment or arrival:</h2>
                                </div>
                                @foreach($hotel['orders']['pending'] as $order)
                                    @include('admin.partials.fulfilment-panel', ['order' => $order, 'status' => 'pending', 'key' => $key])
                                @endforeach
                            @endif

                            @if(isset($hotel['orders']['complete']) && count($hotel['orders']['complete']) > 0)
                                <div>
                                    <h2 class="text-lg font-bold mb-6">Completed:</h2>
                                </div>
                                @foreach($hotel['orders']['complete'] as $order)
                                    @include('admin.partials.fulfilment-panel', ['order' => $order, 'status' => 'complete', 'key' => $key])
                                @endforeach
                            @endif
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Handle click on the active hotel (initially the first one)
            $('#hotelsDropdown').on('click', 'li.active', function () {
                $('#hotelsDropdown li').not('.active').toggleClass('hidden');
            });

            // Handle click on non-active hotel elements
            $('#hotelsDropdown').on('click', 'li:not(.active)', function () {
                // Hide all order panels
                $('.orders-panel').addClass('hidden');

                // Show the targeted order panel
                const target = $(this).data('target');
                $(`#${target}`).removeClass('hidden');

                // Update active state for the clicked hotel and hide others
                $('#hotelsDropdown li').removeClass('active').addClass('hidden');
                $(this).addClass('active').removeClass('hidden');
            });

            $('[data-action="fulfilOrder"]').on('change', function () {
                const orderId = $(this).attr('id').replace('order', '');
                const key = $(this).data('key');
                const status = $(this).is(':checked') ? 'complete' : 'pending';

                const that = $(this);
                $.ajax({
                    url: `/fulfil-order/`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        orderId: orderId,
                        status: status,
                        key: key
                    },
                    success: function (response) {
                        that.parents('.fulfilment-panel').addClass('temporary-complete')
                        console.log(response);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });

    </script>

</x-app-layout>
