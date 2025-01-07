<x-hotel-admin-layout>
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
                            <table class="w-full rounded">
                                <thead>
                                <tr class="text-left bg-grey">
                                    <th class="p-2">Arrival Date</th>
                                    <th class="p-2">Name</th>
{{--                                    <th class="p-2">Order Date</th>--}}
                                    <th class="p-2">Items</th>
                                    <th class="p-2 ">Payment Status</th>
                                    <th class="p-2">Actions</th>
                                </tr>
                                </thead>
                                @foreach($orders as $order)

{{--                                    {{dd($order->order_items)}}--}}

                                    <tr class="border">
                                        <td class="p-2">{{$order->arrival_date}}</td>
                                        <td class="p-2">{{$order->name}}</td>
{{--                                        <td class="p-2">{{$order->created_at}}</td>--}}
                                        <td class="p-2">
                                            <ul>
                                                @foreach($order->items as $item)
                                                    <li>{{$item->product_name}} @if($item->product_type == 'variable') <br><span class="text-sm">{{$item->variation_name}}</span> @endif</li>
                                                @endforeach
                                                <li class="font-bold">£{{\App\Helpers\Money::format($order->total)}}</li>
                                            </ul>
                                        </td>
                                        <td class="p-2 capitalize">{{$order->payment_status}}</td>
                                        <td class="p-2">
                                            <a href="/admin/order/{{$order->id}}/edit">Edit</a>
                                        </td>
                                    </tr>

                                @endforeach
                            </table>

                            {{$orders->links()}}
                        </div>

                    @endif


                </div>
            </div>
        </div>
    </div>
</x-hotel-admin-layout>
