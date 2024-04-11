<x-guest-layout>
    <div class="px-4 pt-6">
        <div class="flex items-center justify-start mb-6">
            <div class="bg-gold px-4 py-6  rounded-3xl mr-4">
                <img style="width: 50px; height: 50px; object-fit: contain" src="{{$hotel->logo}}" alt="hotel"
                     class=""/>
            </div>
            <p>Hi {{($data['name'])}},<br>
                It’s just {{$data['days_until_arrival']}} days until you arrive!<br>
                To personalise your stay, select from the options below.
            </p>
        </div>
        <hr>

        <div class="flex items-end justify-end py-3">
            <div class="bg-white border border-black rounded-lg px-3 py-1">
                <a class="flex items-center justify-between relative" href="/hotel/{{$hotel->id}}/cart" class="text-black">View
                    Cart
                    <img src="/img/icons/cart.svg" alt="cart" class="w-4 h-4 ml-2">
                    @if($cart && $cart['cartCount'] > 0)
                   <span class="bg-teal text-black rounded-full px-2 py-1 ml-2 absolute right-0 top-0 translate-x-full -translate-y-1/2 text-xs">{{$cart['cartCount']}}</span>
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
                        <img src="{{$product->image}}" alt="{{$product->name}}" class="w-full"/>
                    </div>
                    <div>
                        <h3>{{$product->name}}</h3>
                        <p><strong>£{{App\Helpers\Money::addTaxAndFormat($product->price)}}</strong></p>
                    </div>

                </a>

            @endforeach

        </div>
    </div>

</x-guest-layout>
