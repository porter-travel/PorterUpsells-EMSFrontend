<x-guest-layout>


    <div class="">

        <div class="flex items-center justify-between p-4">
            <a href="/hotel/{{$hotel_id}}/dashboard">
                <svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 1L2 7L8 13" stroke="black" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </a>

            <div class="bg-gold px-4 py-6  rounded-3xl">
                <img src="{{$hotel->logo}}" alt="{{$hotel->name}}" class="w-[30px]"/>
            </div>

            <a href="/hotel/{{$hotel_id}}/cart" class="text-black text-sm relative">
                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.3055 1H1.94213C1.62809 3.8 1 9.96 1 12.2C1 14.44 2.88426 15 3.82639 15H10.4213C13.4361 15 13.2477 13.1333 13.2477 12.2L12.3055 1Z"
                        stroke="black" stroke-linecap="round"/>
                    <path
                        d="M9.64546 1C9.92536 2.16667 9.8131 4.5 7.12486 4.5C4.43662 4.5 4.32461 2.16667 4.60464 1H9.64546Z"
                        stroke="black"/>
                </svg>
                <span id="cartCount"
                      class="bg-teal text-black rounded-full px-2 py-1 ml-2 absolute left-0 bottom-0 -translate-x-full translate-y-1/2 text-xs">
                @if($cart && $cart['cartCount'] > 0)

                        {{$cart['cartCount']}}
                    @endif

                    </span>
            </a>
        </div>
    </div>
    <div class="container mx-auto p-4 mt-4">
        <div class="flex flex-wrap">
            <div class="lg:basis-1/2 basis-full lg:pr-4">
                <img src="{{$product->image}}" alt="{{$product->name}}" class="w-full">
            </div>
            <div class="lg:basis-1/2 basis-full lg:pl-4">
                <div class="mt-4 lg:mt-0">
                    <p>{{$product->name}}</p>
                    <p>£{{App\Helpers\Money::addTaxAndFormat($product->price)}}</p>
{{--                    <small>Tax Included</small>--}}
                </div>

                <div>
                    <form id="addToCart" action="/cart/add" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                        <input type="hidden" name="product_name" value="{{$product->name}}">
                        <div class="mt-4">
                            <label class="block w-full" for="options">Options</label>
                            <select id="options" name="variation_id">
                                @foreach($variations as $variation)
                                    <option value="{{$variation->id}}">{{$variation->name}} -
                                        £{{App\Helpers\Money::addTaxAndFormat($variation->price)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="quantity" :value="__('Quantity')"/>
                            <div class="w-[100px]">
                                <x-number-input :key="'quantity'" :quantity="1"/>
                            </div>
                        </div>
                        <x-primary-button class="w-full justify-center mt-4">Add to basket</x-primary-button>

                        <span id="success"
                              class="hidden text-black bg-teal my-4 p-2 w-full block">Added to basket</span>
                    </form>
                </div>

                <div class="mt-4">
                    {{$product->description}}
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
