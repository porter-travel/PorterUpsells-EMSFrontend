<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar Orders for: ') . $hotel->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap">
                    @if(count($products) > 0)
                        @foreach($products as $product)
                            <div class="lg:basis-1/4 md:basis-1/2 basis-full lg:pr-4">
                                <a href="{{route('calendar.list-bookings-for-product', ['hotel_id' => $hotel->id, 'product_id' => $product->id])}}"
                                   class="flex items-start justify-between flex-col w-full px-4 mb-4">
                                    <div class="w-full mb-2">
                                        @include ('hotel.partials.product-image', ['item' => $product])
                                    </div>
                                    <div>
                                        <h3 class="hotel-text-color open-sans text-sm md:text-xl">{{$product->name}}</h3>

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-hotel-admin-layout>
