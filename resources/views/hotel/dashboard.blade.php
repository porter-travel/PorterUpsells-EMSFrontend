<x-guest-layout>

    @include('hotel.partials.css-overrides', ['hotel' => $hotel])
    <div class="px-4 pt-6">
        <div class="flex items-end justify-start mb-6 flex-wrap">
            <div
                class="md:basis-7/12 basis-full md:h-[250px] h-[165px] relative rounded p-4 flex flex-col mt-6 "
                style="background: url({{$hotel->featured_image}}) no-repeat center center / cover">
                <div
                    class="absolute inset-0 rounded"
                    style="background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);"></div>
                <div class="mt-auto relative z-10 flex items-end">
                    <img style="width: 70px; height: 70px; object-fit: contain" src="{{$hotel->logo}}" alt="hotel"
                         class="rounded"/>
                    <p class="text-2xl text-white font-bold ml-6">{{$hotel->name}}</p>
                </div>
            </div>

            <div class="md:basis-5/12 basis-full md:pl-12 pt-4 md:pt-0">
                <p class="hotel-text-color open-sans font-semibold md:text-2xl mb-6">Hi {{($data['name'])}},</p>
                <div class="flex items-start justify-start mb-3">
                    <div>
                    <svg class="mr-2 mt-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="10" fill="{{$hotel->accent_color ?? '#C7EDF2'}}" stroke="{{$hotel->accent_color ?? '#C7EDF2'}}" stroke-width="2"/>
                        <path d="M5.78906 11.543L8.53906 14.293L14.7266 8.10547" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    </div>
                    <p class="open-sans md:text-xl pl-2 hotel-text-color">It’s just {{$data['days_until_arrival']}} days until you arrive!</p>
                </div>
                <div class="flex items-start justify-start mb-3">
<div>
                <svg class="mr-2 mt-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="10" stroke="#5A5A5A" stroke-width="2"/>
                    <path d="M7.45633 16V14.6728L11.3066 11.4494C11.6108 11.2051 11.8342 10.986 11.9768 10.7921C12.1194 10.5983 12.2145 10.4213 12.262 10.2612C12.3191 10.1011 12.3476 9.95365 12.3476 9.81882C12.3476 9.46489 12.2097 9.19522 11.934 9.00983C11.6679 8.81601 11.2733 8.7191 10.7504 8.7191C10.3321 8.7191 9.94236 8.79073 9.5811 8.93399C9.22935 9.07725 8.92989 9.30056 8.68271 9.60393L7 8.64326C7.38027 8.13764 7.91266 7.73736 8.59715 7.44242C9.28164 7.14747 10.0707 7 10.9643 7C11.7059 7 12.3523 7.10955 12.9037 7.32865C13.4646 7.53933 13.8972 7.83848 14.2014 8.22612C14.5152 8.61376 14.672 9.07725 14.672 9.61657C14.672 9.90309 14.6292 10.1896 14.5437 10.4761C14.4676 10.7542 14.306 11.0492 14.0588 11.361C13.8212 11.6728 13.4694 12.0225 13.0036 12.4101L9.80927 15.0772L9.3672 14.3315H15V16H7.45633Z" fill="#5A5A5A"/>
                </svg>
</div>
                <p class="open-sans md:text-xl pl-2 hotel-text-color">To personalise your stay, select from the options below.</p>
                </div>
            </div>
        </div>
        <hr>

        <div class="flex items-end justify-end py-3">
            <div class="bg-white border border-black rounded-lg px-3 py-1">
                <a class="flex items-center justify-between relative" href="/hotel/{{$hotel->id}}/cart"
                   class="text-black">View
                    Cart
                    <img src="/img/icons/cart.svg" alt="cart" class="w-4 h-4 ml-2">
                    @if($cart && $cart['cartCount'] > 0)
                        <span
                            class="hotel-accent-color-50 text-black rounded-full px-2 py-1 ml-2 absolute right-0 top-0 translate-x-full -translate-y-1/2 text-xs">{{$cart['cartCount']}}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="flex items-center flex-wrap px-8 -mx-4">
            @foreach($products as $product)
                <a href="/hotel/{{$hotel->id}}/item/{{$product->id}}"
                   class="flex items-start justify-between flex-col basis-1/2 md:basis-1/3 lg:basis-1/4 w-1/2 px-4 mb-4">
                    <div>
                        <img src="{{$product->image}}" alt="{{$product->name}}" class="w-full rounded"/>
                    </div>
                    <div>
                        <h3 class="hotel-text-color open-sans text-sm md:text-xl">{{$product->name}}</h3>
                        <p class="hotel-text-color open-sans text-sm md:text-xl font-semibold"><strong>£{{App\Helpers\Money::addTaxAndFormat($product->price)}}</strong></p>
                    </div>

                </a>

            @endforeach

        </div>
    </div>

</x-guest-layout>
