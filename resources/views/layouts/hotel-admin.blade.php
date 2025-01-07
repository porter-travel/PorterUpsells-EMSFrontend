@props(['hotel'])

<x-app-layout>
    @if(isset($hotel))
        <x-slot name="hotelNav">
            <div class="bg-lightBlue">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="py-6 flex items-center justify-start">
                        <h1 class="text-2xl font-extrabold text-black leading-tight mr-6">
                            {{ $hotel->name }}:
                        </h1>

                        <ul class="flex items-center justify-start">
                            <li class="mr-4 text-xl">
                                <a href="{{route('hotel.edit', ['id' => $hotel->id])}}">Dashboard</a>
                            </li>
                            <li class="mr-4 text-xl">
                                <a href="{{route('orders.listItemsForPicking', ['hotel_id' => $hotel->id])}}">Orders</a>
                            </li>
                            <li class="mr-4 text-xl">
                                <a href="{{route('bookings.list', ['id' => $hotel->id])}}">Guests</a>
                            </li>
{{--                            <li class="mr-4 text-xl">--}}
{{--                                <a href="{{route('calendar.list-product-grid', ['id' => $hotel->id])}}">Calendar</a>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </x-slot>
    @endif
    @isset($header)
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endisset

    {{ $slot }}
</x-app-layout>
