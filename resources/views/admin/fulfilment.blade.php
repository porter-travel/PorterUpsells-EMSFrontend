<x-app-layout>
{{--        {{dd($hotels)}}--}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fulfilment
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @foreach($hotels as $hotel)

                        <div>
                            <h2 class="text-xl font-bold mb-6">{{$hotel['name']}}</h2>

                            @foreach($hotel['orders'] as $order)
                                <div class=" border mb-4">
                                <p>Guest: {{$order['name']}}</p>
                                <p>Room Number: {{$order['booking']['room']}}</p>
                                <p>Guest: @if($order['booking']['checkin']) Checked-in @else Not Arrived @endif</p>

                            <p><strong>Order Details</strong></p>
                                @foreach($order['items'] as $item)
                                    <p>{{$item['quantity']}} x {{$item['product_name']}}</p>
                                @endforeach
                                </div>
                            @endforeach
                        </div>

                    @endforeach



                </div>
            </div>
        </div>
    </div>


</x-app-layout>
