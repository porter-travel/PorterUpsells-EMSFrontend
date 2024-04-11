<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders for: ') . $hotel->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(count($orders) > 0)

                        <div class="flex flex-wrap">
                            <table class="w-full table-fixed">
                                <thead>
                                <tr class="text-left">
                                    <th class="p-2">Booking Ref</th>
                                    <th>Name</th>
                                    <th class="p-2">Arrival Date</th>
                                    <th class="p-2">Order Status</th>
{{--                                    <th class="p-2">Order Date</th>--}}
                                    <th class="p-2">Order Items</th>
                                    <th class="p-2">Actions</th>
                                </tr>
                                </thead>
                                @foreach($orders as $order)

                                    <tr class="border">
                                        <td class="p-2">{{$order->booking_ref}}</td>
                                        <td class="p-2">{{$order->name}}</td>
                                        <td class="p-2">{{$order->arrival_date}}</td>
                                        <td class="p-2">{{$order->payment_status}}</td>
{{--                                        <td class="p-2">{{$order->created_at}}</td>--}}
                                        <td class="p-2">
                                            <ul>
                                                @foreach(json_decode($order->items) as $item)
                                                    @if(is_object($item))
                                                        <li>{{$item->product_name}} - £{{$item->price}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="p-2">
                                            <a href="/admin/order/{{$order->id}}/edit">Edit</a>
                                        </td>
                                    </tr>

                                @endforeach
                            </table>
                        </div>

                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
