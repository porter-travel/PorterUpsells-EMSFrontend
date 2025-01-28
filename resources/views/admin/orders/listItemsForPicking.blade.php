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
                    <x-date-filter-bar :startDate="$startDate" :endDate="$endDate"/>

                    @if(count($orders) > 0)

                        <div class="flex flex-wrap">
                            <table class="w-full rounded">
                                <thead>
                                <tr class="text-left bg-grey">
                                    <th class="p-2">Booking Ref</th>
                                    <th class="p-2">Checkin</th>
                                    <th class="p-2">Name</th>
                                    {{--                                    <th class="p-2">Order Date</th>--}}
                                    <th class="p-2">Items</th>
                                    <th class="p-2 ">Status</th>
                                </tr>
                                </thead>
                                @foreach($orders as $order)

                                    <tr class="border">
                                        <td class="p-2">{{$order['booking_ref']}}</td>
                                        <td class="p-2">{{date_create_from_format('Y-m-d', $order['arrival_date'])->format('d/m/Y')}}</td>
                                        <td class="p-2">{{$order['name']}}</td>
                                        {{--                                        <td class="p-2">{{$order->created_at}}</td>--}}
                                        <td class="p-2">
                                            @foreach($order['items'] as $item)
                                                {{$item['quantity']}} x
                                                {{$item['name']}}
                                                @if($item['product_type'] == 'variable')
                                                    <br><span class="text-sm">{{$item['variation_name']}}</span>
                                                @endif
                                            @foreach($item['meta'] as $meta)
                                                @if($meta['key'] == 'arrival_time')
                                                    <br><span class="text-sm">Time: {{$meta['value']}}</span>
                                                @endif
                                            @endforeach
                                                <br>
                                            @endforeach
                                        </td>
                                        <td class="p-2

                                        @if($order['status'] == 'cancelled')
                                        bg-red
@elseif($order['status'] == 'complete')
                                        bg-mint
@elseif($order['status'] == 'pending')
                                        bg-pink
                                        @endif
                                        ">
                                            <form class="orderItemUpdate" method="post"
                                                  action="{{route('order.update')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$order['id']}}">

                                                <select name="status" class="order-status-select">
                                                    @foreach(\App\Enums\OrderStatus::getValues() as $value)
                                                        <option @if($order['status'] == $value) selected
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
</x-hotel-admin-layout>
