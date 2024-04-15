<x-guest-layout>
    <div class="">
        <div class="flex items-center justify-between p-4">
            <a href="/hotel/{{$hotel_id}}/dashboard">
                <svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 1L2 7L8 13" stroke="black" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </a>

            <p>Your Cart</p>

            <div></div>
        </div>

        <div class="lg:bg-white flex flex-wrap rounded-3xl max-w-[900px] mx-auto p-4">
            <div class="lg:basis-1/2 basis-full">
                @foreach($data['cart'] as $key => $item)
                    @if(isset($item['image']))
                        <div class=" mb-4">
                            <div id="cartItem{{$key}}" class="flex items-start justify-start mb-4">
                                <div class="w-[150px] ">
                                    <img src="{{$item['image']}}" alt="{{$item['name']}}" class="w-full">
                                </div>
                                <div class="basis-3/4 pl-4">
                                    <p><strong>{{$item['product_name']}}</strong></p>
                                    <p>£{{$item['price']}}</p>
                                    @if($item['name'])
                                        <p>Options: {{$item['name']}}</p>
                                    @endif
                                    <div class="flex items-center">
                                        <x-number-input :key="$key" :quantity="$item['quantity']"/>
                                        <a class="remove-from-cart ml-4" data-key="{{$key}}" href="/cart/remove/{{$key}}">
                                            <img src="/img/icons/bin.svg" alt="remove" class="w-4 h-4">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="lg:basis-1/2 basis-full">

                <table class="table-fixed w-full border-collapse border border-gold/50 rounded-xl">
                    <tbody>
{{--                    <tr class="border-b border-gold/50">--}}
{{--                        <td class="p-2 border-r border-gold/50">Subtotal</td>--}}
{{--                        <td class="p-2" id="cartSubtotal">£{{App\Helpers\Money::format($data['cart']['total'])}}</td>--}}
{{--                    </tr>--}}
{{--                    <tr class="border-b border-gold/50">--}}
{{--                        <td class="p-2 border-r border-gold/50">Tax</td>--}}
{{--                        <td class="p-2" id="cartTax">£{{App\Helpers\Money::format($data['cart']['tax'])}}</td>--}}
{{--                    </tr>--}}
                    <tr class="border-b border-gold/50">
                        <td class="p-2 border-r border-gold/50">Total</td>
                        <td class="p-2" id="cartTotal">£{{App\Helpers\Money::format($data['cart']['total'])}}</td>
                    </tr>
                    </tbody>
                </table>
                <x-primary-button class="w-full justify-center mt-4"><a href="/checkout/initiate/{{$hotel_id}}">Checkout</a></x-primary-button>

            </div>
        </div>
    </div>

</x-guest-layout>
