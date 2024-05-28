<x-guest-layout>
    <div class="mt-28 mx-4">
        <div class="bg-pink px-8 pt-20 pb-12 max-w-[667px] mx-auto rounded-3xl relative">
            <div class="absolute -top-24 bg-yellow px-8 py-6 left-1/2 -translate-x-1/2 rounded-3xl">
                <img style="width: 80px; height: 114px; object-fit: contain" src="/img/hank.png" alt="hotel"
                     class=""/>
            </div>

            <p class="text-black text-center open-sans text-2xl border-b border-darkGrey pb-6">
                Thank you for personalising your upcoming stay
            </p>

            <p class="text-xl font-bold open-sans my-4">Your Order</p>

            @foreach($cartItems as $item)
                @if(isset($item['image']))
                    <div class="flex items-center justify-start mb-4">
                        <div class="w-[150px] mr-4">
                            <img src="{{$item['image']}}" alt="{{$item['variation_name']}}"
                                 class="rounded md:w-[150px] w-[80px]">
                        </div>
                        <div>
                            <p><strong>{{$item['product_name']}}</strong></p>
                            @if($item['product_type'] == 'variable')
                                <p>Options: {{$item['variation_name']}}</p>
                            @endif

                            <p>Date: {{ \Carbon\Carbon::parse($item['date'])->format('jS M') }}</p>
                            <p class="cart-product-subtotal text-xl font-bold">£{{$item['price'] * $item['quantity']}}</p>

                        </div>
                    </div>
                @endif

            @endforeach


        </div>
    </div>
</x-guest-layout>
