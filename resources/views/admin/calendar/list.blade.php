<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar Orders for: ') . $hotel->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="get">
                        @csrf
                        <div class="flex items-center pb-6">
                            <div>
                                <label>Start Date
                                    <input type="date" name="start_date" value="{{$startDate}}"></label>
                            </div>

                            <div class="mx-4">
                                <label>End Date
                                    <input type="date" name="end_date" value="{{$endDate}}"></label>
                            </div>
                            <div>
                                <x-secondary-button type="submit">Filter</x-secondary-button>
                            </div>
                        </div>
                    </form>

                    @if(count($orders) > 0)
                        @foreach($orders as $date => $items)

                            <h2 class="text-2xl font-bold text-gray-800">{{ \App\Helpers\Date::formatToDayAndMonth($date) }}</h2>
                            <div class="flex flex-wrap">
                                @foreach($items as $item)
                                    <div class=" p-4 lg:basis-1/4 md:basis-1/2 basis-full">
                                        <div class="bg-lightBlue p-4">
                                            <h3 class="text-lg font-bold">{{$item['product_name']}}</h3>
                                            <div class="">
                                                <p>Guest: {{ $item['name'] }}</p>

                                                <p>Qty: {{$item['quantity']}}</p>
                                                <p>From: {{$item['arrival_time']}}</p>
                                                <p>Until: {{$item['end_time']}}</p>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>

                        @endforeach

                    @else

                        <p>No orders to show</p>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-hotel-admin-layout>
