<x-guest-layout>
    <x-slot:favicon>{{$hotel->logo}}</x-slot:favicon>

    @include('hotel.partials.css-overrides', ['hotel' => $hotel])

    <div class="mx-4">
        <div class="flex items-center justify-between p-4 border-b border-darkGrey">
            <a href="/hotel/{{$hotel_id}}/dashboard">
                <svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 1L2 7L8 13" stroke="black" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </a>

            <p class="md:text-4xl text-xl font-bold open-sans hotel-text-color">Your Cart</p>



            <div></div>
        </div>
        <div class="bg-pink w-[200px] mx-auto rounded mt-4 text-center">
            <p class="inline-block ">Cart Expires in <span id="cartCountdown" data-expiry="{{isset($data['cart']['expiry']) ? $data['cart']['expiry'] : ''}}"></span></p>
        </div>

        <div class=" flex flex-wrap rounded-3xl mx-auto py-4">

            <div class="hidden md:flex items-start w-full border-b border-darkGrey">
                <div class="md:w-[40%]">
                    <p class="hotel-text-color text-xl mb-4">Product</p>
                </div>
                <div class="md:w-[20%]">
                    <p class="hotel-text-color text-xl mb-4">Price</p>
                </div>
                <div class="md:w-[20%]">
                    <p class="hotel-text-color text-xl mb-4">Quantity</p>
                </div>
                <div class="md:w-[20%]">
                    <p class="hotel-text-color text-xl mb-4">Total</p>
                </div>
            </div>

            <div class="basis-full">
{{--                {{dd($data)}}--}}
                @if(isset($data['cart']) && count($data['cart']) > 0)
                    @foreach($data['cart'] as $key => $item)
                        @if(isset($item['image']))
                            <div class=" my-4 py-4 border-b border-darkGrey hotel-text-color ">
                                <div id="cartItem{{$key}}"
                                     class="flex  md:items-center items-start justify-between md:justify-start mb-4 relative">
                                    <div class="md:w-[40%]">
                                        <div class="flex md:items-center items-start justify-start flex-col sm:flex-row">
                                            <div class="md:w-[150px] w-[80px] mr-4">
                                                @include ('hotel.partials.product-image', ['item' => $item])
                                            </div>
                                            <div>
                                                <p><strong>{{$item['product_name']}}</strong></p>
                                                @if($item['product_type'] == 'variable')
                                                    <p>Options: {{$item['variation_name']}}</p>
                                                @endif

                                                <p>Date: {{ \Carbon\Carbon::parse($item['date'])->format('jS M') }}</p>
                                                @if($item['arrival_time'])
                                                    <p>Time: {{$item['arrival_time']}}</p>
                                                @endif
                                                <p class=" md:hidden">
                                                    <x-money-display :amount="$item['price']"
                                                                                       :currency="$hotel->user->currency"></x-money-display>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden md:block md:w-[20%]">
                                        <p class="text-xl">
                                            <x-money-display :amount="$item['price']"
                                                             :currency="$hotel->user->currency"></x-money-display></p>
                                    </div>
                                    <div class="md:w-[20%]">
                                        <div class="w-[100px] text-black">
                                            <x-number-input :key="$key" :max="$item['max_qty']" :quantity="$item['quantity']"/>
                                        </div>
                                        <a class="remove-from-cart ml-4 absolute bottom-0 md:hidden" data-key="{{$key}}"
                                           href="/cart/remove/{{$key}}">
                                            <img src="/img/icons/bin.svg" alt="remove" class="w-4 h-4">
                                        </a>
                                    </div>
                                    <div class="md:w-[20%] hidden md:block">
                                        <p class=" cart-product-subtotal text-xl font-bold">

                                            <x-money-display :amount="$item['price'] * $item['quantity']"
                                                             :currency="$hotel->user->currency"></x-money-display>
                                        </p>

                                        <div class="flex items-center">
                                            <a class="remove-from-cart ml-4 absolute bottom-0" data-key="{{$key}}"
                                               href="/cart/remove/{{$key}}">
                                                <img src="/img/icons/bin.svg" alt="remove" class="w-4 h-4">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
            </div>

            <div class="lg:basis-1/2 ml-auto">

                <table class="table-fixed w-full border-collapse">
                    <tbody>
                    {{--                    <tr class="border-b border-gold/50">--}}
                    {{--                        <td class="p-2 border-r border-gold/50">Subtotal</td>--}}
                    {{--                        <td class="p-2" id="cartSubtotal">£{{App\Helpers\Money::format($data['cart']['total'])}}</td>--}}
                    {{--                    </tr>--}}
                    {{--                    <tr class="border-b border-gold/50">--}}
                    {{--                        <td class="p-2 border-r border-gold/50">Tax</td>--}}
                    {{--                        <td class="p-2" id="cartTax">£{{App\Helpers\Money::format($data['cart']['tax'])}}</td>--}}
                    {{--                    </tr>--}}
                    <tr class=" hotel-text-color">
                        <td class="p-2 md:text-3xl">Total</td>
                        <td class="p-2 md:text-3xl font-bold text-right" id="cartTotal">
                            <x-money-display :amount="$data['cart']['total']"
                                             :currency="$hotel->user->currency"></x-money-display>
                            </td>
                    </tr>
                    </tbody>
                </table>
                <x-primary-button class="w-full justify-center mt-4 hotel-button-color hotel-button-text-color"><a
                        href="/checkout/initiate/{{$hotel_id}}">Checkout</a></x-primary-button>

            </div>
            @endif
        </div>
    </div>

</x-guest-layout>
