<x-guest-layout>

    <x-slot:title>
        Personalise your upcoming stay at {{$hotel->name}}
        </x-slot>
        <x-slot:favicon>{{$hotel->logo}}</x-slot:favicon>


        @include('hotel.partials.css-overrides', ['hotel' => $hotel])
    <div class="px-4">
        <div class="flex items-end justify-start mb-6 flex-wrap">
            <div
                class="md:basis-7/12 basis-full md:h-[250px] h-[165px] relative rounded p-4 flex flex-col mt-6 "
                style="background: url({{$hotel->featured_image}}) no-repeat center center / cover">
                <div
                    class="absolute inset-0 rounded"
                    style="background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);"></div>
                <div class="mt-auto relative z-10 flex items-end">
                    @include ('hotel.partials.hotel-logo', ['hotel' => $hotel])
                    <p class="text-2xl text-white font-bold ml-6">{{$hotel->name}}</p>
                </div>
            </div>

            <div class="md:basis-5/12 basis-full md:pl-12 pt-4 md:pt-0">
                <p class="hotel-text-color open-sans font-semibold md:text-2xl mb-6">Welcome, {{$data['name'] ?? ''}}</p>
{{--                <div class="flex items-start justify-start mb-3">--}}
{{--                    <div>--}}
                {{--                    <svg class="mr-2 mt-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                {{--                        <circle cx="11" cy="11" r="10" fill="{{$hotel->accent_color ?? '#C7EDF2'}}" stroke="{{$hotel->accent_color ?? '#C7EDF2'}}" stroke-width="2"/>--}}
                {{--                        <path d="M5.78906 11.543L8.53906 14.293L14.7266 8.10547" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round"/>--}}
                {{--                    </svg>--}}
{{--                    </div>--}}
{{--                    <p class="open-sans md:text-xl pl-2 hotel-text-color">It’s just {{$data['days_until_arrival']}} days until you arrive!</p>--}}
{{--                </div>--}}
                <div class="flex items-start justify-start mb-3">
<div>
                        <svg class="mr-2 mt-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="10" fill="{{$hotel->accent_color ?? '#C7EDF2'}}" stroke="{{$hotel->accent_color ?? '#C7EDF2'}}" stroke-width="2"/>
                            <path d="M5.78906 11.543L8.53906 14.293L14.7266 8.10547" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round"/>
                        </svg>
</div>
                <p class="open-sans md:text-xl pl-2 hotel-text-color">To personalise your stay, select from the options below.</p>
                </div>
            </div>
        </div>
        <hr>

        <div class="flex items-end justify-end py-3">
            <div class="bg-white border border-black rounded-lg px-3 py-1">
                <a class="flex items-center justify-between relative" href="/hotel/{{$hotel->slug ?? $hotel->id}}/cart"
                   class="text-black">View
                    Cart
                    <img src="/img/icons/cart.svg" alt="cart" class="w-4 h-4 ml-2">
                    @if($cart && isset($cart['cartCount']) && $cart['cartCount'] > 0)
                        <span
                            class="hotel-accent-color text-black rounded-full px-2 py-1 ml-2 absolute right-0 top-0 translate-x-full -translate-y-1/2 text-xs">{{$cart['cartCount']}}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="flex items-start flex-wrap  -mx-4 mt-4">
            @foreach($products as $product)
                <a href="/hotel/{{$hotel->slug ?? $hotel->id}}/item/{{$product->id}}"
                   class="flex items-start justify-between flex-col basis-1/2 md:basis-1/3 lg:basis-1/4 w-1/2 px-4 mb-4">
                    <div class="w-full mb-2">
                        @include ('hotel.partials.product-image', ['item' => $product])                    </div>
                    <div>
                        <h3 class="hotel-text-color open-sans text-sm md:text-xl">{{$product->name}}</h3>
                        <p class="hotel-text-color open-sans text-sm md:text-xl font-semibold"><strong>
                                @if(is_countable($product->variations) && count($product->variations) <= 1)
                                    <x-money-display :amount="$product->price"
                                                     :currency="$hotel->user->currency"></x-money-display>
                                @else
                                    <x-money-display :amount="$product->variations[0]->price"
                                                     :currency="$hotel->user->currency"></x-money-display>
                                @endif

                            </strong></p>
                    </div>

                </a>

            @endforeach

        </div>
    </div>

</x-guest-layout>
