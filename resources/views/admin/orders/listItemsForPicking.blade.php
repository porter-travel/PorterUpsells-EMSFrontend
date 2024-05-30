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
                            <table class="w-full rounded">
                                <thead>
                                <tr class="text-left bg-grey">
                                    <th class="p-2">Booking Ref</th>
                                    <th class="p-2">Date Requested</th>
                                    <th class="p-2">Name</th>
                                    {{--                                    <th class="p-2">Order Date</th>--}}
                                    <th class="p-2">Items</th>
                                    <th class="p-2 ">Status</th>
                                </tr>
                                </thead>
                                @foreach($orders as $order)

                                    {{--                                    {{dd($order->order_items)}}--}}

                                    <tr class="border">
                                        <td class="p-2">{{$order['item']->booking_ref}}</td>
                                        <td class="p-2">{{date_create_from_format('Y-m-d', $order['item']->date)->format('d/m/Y')}}</td>
                                        <td class="p-2">{{$order['order_name']}}</td>
                                        {{--                                        <td class="p-2">{{$order->created_at}}</td>--}}
                                        <td class="p-2">
                                            {{$order['item']->quantity}} x
                                            {{$order['item']->product_name}} @if($order['item']->product_type == 'variable')
                                                <br><span class="text-sm">{{$order['item']->variation_name}}</span>
                                            @endif
                                        </td>
                                        <td class="p-2

                                        @if($order['item']->status == 'cancelled')
                                        bg-red
@elseif($order['item']->status == 'fulfilled')
                                        bg-mint
@elseif($order['item']->status == 'pending')
                                        bg-pink
                                        @endif
                                        ">
                                            <form class="orderItemUpdate" method="post"
                                                  action="{{route('orderItem.update', $order['item']->id)}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$order['item']->id}}">

                                                <select name="status" class="order-status-select">
                                                    @foreach(\App\Enums\OrderStatus::getValues() as $value)
                                                        <option @if($order['item']->status == $value) selected
                                                                @endif value="{{$value}}">{{ucfirst($value)}}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach
                            </table>

                        </div>

                    @else

                        <p>No orders to show</p>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
