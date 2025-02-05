<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders for: ') . $hotel->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-date-filter-bar :startDate="$startDate" :endDate="$endDate" :status="$filterStatus" :exportLink="route('orders.export-to-csv', $hotel->id)"/>

                    @if(count($orders) > 0)

                        <div class="flex flex-wrap">
                            <table class="w-full rounded border-b">
                                <thead>
                                <tr class="text-left bg-grey border-grey">
                                    <th class="p-2 rounded-tl-2xl">Booking Ref</th>
                                    <th class="p-2">Room</th>
                                    <th class="p-2">Fulfilment Date</th>
                                    <th class="p-2 ">Name</th>
                                    <th class="p-2">Items</th>
                                    <th class="p-2 rounded-tr-2xl">Fulfilment Status</th>
                                </tr>
                                </thead>
                                @foreach($orders as $key => $order)
                                    @php
                                        if($key >= 1 && $order->order->id == $orders[$key-1]->order->id){
                                            $classes = '';
                                        } else {
                                              $classes = 'border-t';
                                        }
@endphp
                                    {{--                                    {{dd($order->order_items)}}--}}

                                    <tr class="">

                                        <td class="p-2 border-l {{$classes}}">{{$order->order->booking_ref}}</td>
                                        <td class="p-2 {{$classes}}">
                                            <form class="update-form flex" method="post" action="/admin/order/update">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$order->order->id}}">
                                                <input name="room" class="w-20" value="{{$order->order->room_number}}">
                                                <button type="submit" class="update-room bg-grey border-r border-y rounded-tr rounded-br px-2">✓</button>
                                            </form>
                                        </td>
                                        <td class="p-2 {{$classes}}">{{\App\Helpers\Date::formatToDayAndMonth($order->date)}}</td>
                                        <td class="p-2 {{$classes}}">{{$order->order->name}}</td>
                                        <td class="p-2 {{$classes}}">
                                            {{$order->quantity}} x
                                            {{$order->product_name}}
                                            @if($order->product_type == 'variable')
                                                <br><span class="text-sm">{{$order->variation_name}}</span>
                                            @endif
                                            @foreach($order->meta as $meta)
                                                @if($meta->key == 'arrival_time')
                                                    <br><span class="text-sm">Time: {{$meta->value}}</span>
                                                @endif
                                            @endforeach
                                            <br>
                                        </td>

                                        <td class="p-2 border-r {{$classes}}">
                                            <form class="orderItemUpdate" method="post"
                                                  action="{{route('orderItem.update', $order->id)}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$order->id}}">
                                                @php
                                                    $statusColors = [
                                                        'cancelled' => 'bg-red',
                                                        'complete' => 'bg-mint',
                                                        'fulfilled' => 'bg-mint',
                                                        'pending' => 'bg-pink',
                                                    ];
                                                @endphp
                                                <select name="status" class="order-status-select rounded-full {{ $statusColors[$order->status] ?? '' }}">

                                                @foreach(\App\Enums\OrderStatus::getValues() as $value)
                                                        @if($value == 'complete')
                                                            @continue
                                                        @endif
                                                        <option @if($order->status == $value) selected
                                                                @endif value="{{$value}}">{{ucfirst($value)}}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>


                                    </tr>


                                @endforeach
                            </table>

                            <div class="flex items-center justify-center mt-8 w-full">

                            {{$orders->links()}}

                            </div>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all forms with the class 'update-form'
            const forms = document.querySelectorAll('.update-form');

            // Iterate through each form
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
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
