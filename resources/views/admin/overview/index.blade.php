<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders and Bookings for: ') . $hotel->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-date-filter-bar :startDate="$startDate" :endDate="$endDate" :status="$filterStatus"
                                       :exportLink="route('orders.export-to-csv', $hotel->id)"/>

                    @if(count($items) > 0)

                        @foreach($items as $key => $item)

                            <h2 class="text-lg mb-4 mt-8 font-bold">{{$key}}</h2>

                            <div class="flex flex-wrap">
                                @foreach($item as $child)

                                    @if(isset($child['product_name']) && $child['product_type'] != 'calendar')
                                        <div class="p-2 lg:basis-1/4 md:basis-1/3 sm:basis-1/2 basis-full">
                                            <div
                                                class="bg-lightBlue p-2 rounded-xl ">
                                                {{--                                            PRODUCT--}}
                                                <p>{{$child['product_name']}}</p>
                                                @if($child['product_name'] != $child['variation_name'])
                                                    <p class="text-sm">({{$child['variation_name']}})</p>
                                                @endif

                                                <p>Qty: {{$child['quantity']}}</p>

                                                <p>Name: {{$child['order']['name']}}</p>
                                                @if($child['order']['room_number'])
                                                    <p>Room: {{$child['order']['room_number']}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-2 lg:basis-1/4 md:basis-1/3 sm:basis-1/2 basis-full">
                                            <div
                                                class="bg-lightBlue p-2 rounded-xl">
                                                {{--                                            CALENDAR--}}
                                                @if(isset($child['product']))
                                                    <p>{{$child['product']['name']}}</p>
                                                @endif

                                                @if(
                                                    isset($child['variation']) &&
                                                    (!isset($child['product']) || (isset($child['product']['name']) && $child['product']['name'] !== $child['variation']['name']))
                                                )
                                                    <p class="text-sm">({{ $child['variation']['name'] }})</p>
                                                @endif

                                                @if(isset($child['qty']))
                                                    <p>Qty: {{$child['qty']}}</p>
                                                @endif

                                                @if(isset($child['name']))
                                                    <p>Name: {{$child['name']}}</p>
                                                @endif

                                                @if(isset($child['room_number']))
                                                    <p>Room: {{$child['room_number']}}</p>
                                                @endif


                                            </div>
                                        </div>

                                    @endif

                                @endforeach
                            </div>

                        @endforeach

                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select all forms with the class 'update-form'
            const forms = document.querySelectorAll('.update-form');

            // Iterate through each form
            forms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission

                    // Get the form action URL and method
                    const url = form.action;
                    const method = form.method;

                    // Create a FormData object from the form
                    const formData = new FormData(form);

                    // Send the AJAX request using fetch
                    fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Optional: to specify AJAX request
                        }
                    })
                        .then(response => response.json()) // Assuming the response is in JSON format
                        .then(data => {
                            // Handle the response (e.g., update the page, display a message, etc.)
                            console.log('Success:', data);

                            // Find the submit button within the current form
                            const button = form.querySelector('.update-room');

                            // Change button background to green
                            button.style.backgroundColor = '#D4F6D1';

                            // Revert button background after 2 seconds
                            setTimeout(() => {
                                button.style.backgroundColor = ''; // Reset to original color
                            }, 2000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle errors (e.g., display an error message)
                        });
                });
            });
        });
    </script>
</x-hotel-admin-layout>
