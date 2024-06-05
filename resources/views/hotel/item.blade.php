<x-guest-layout>

    <x-slot:title>
        {{$product->name}}
        </x-slot>

        <x-slot:favicon>{{$hotel->logo}}</x-slot:favicon>

        @include('hotel.partials.css-overrides', ['hotel' => $hotel])

    <style>
        .fancy-checkbox{
            position: relative;
        }
        .fancy-checkbox input:checked + span{
            background-color: {{$hotel->accent_color ?? '#C7EDF2'}};
            z-index: 10;
        }
        .fancy-checkbox input:checked + span + span{
            content: '';
            position: absolute;
            top: 0;
            bottom:0;
            left:0;
            right:0;
            background-color: {{substr_replace($hotel->accent_color, '80', 1, 0) ?? '#80C7EDF2'}};
        }
    </style>

    <div class="">

        <div class="flex items-center justify-between p-4">
            <a href="/hotel/{{$hotel_id}}/dashboard">
                <svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 1L2 7L8 13" stroke="black" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </a>

            @include ('hotel.partials.hotel-logo', ['hotel' => $hotel])


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
                      class="hotel-accent-color-50 text-black rounded-full px-2 py-1 ml-2 absolute left-0 bottom-0 -translate-x-full translate-y-1/2 text-xs">@if($cart && $cart['cartCount'] > 0)
                        {{$cart['cartCount']}}
                    @endif</span>
            </a>
        </div>
    </div>
    <div class="narrow-container mx-auto p-4 mt-4">
        <form id="addToCart" action="/cart/add" method="post">
            <div class="flex flex-wrap items-end">
                <div class="lg:basis-1/2 basis-full lg:pr-4">
                    @include ('hotel.partials.product-image', ['item' => $product])                </div>
                <div class="lg:basis-1/2 basis-full lg:pl-4">
                    <div class="mt-4 lg:mt-0">
                        <p class="open-sans text-3xl mb-2 hotel-text-color">{{$product->name}}</p>
                        <p class="open-sans text-xl mb-6 hotel-text-color">£{{App\Helpers\Money::addTaxAndFormat($product->price)}}</p>
                        {{--                    <small>Tax Included</small>--}}
                    </div>

                    <div>

                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                        <input type="hidden" name="product_name" value="{{$product->name}}">
                        <div @if(is_countable($variations) && count($variations) <= 1) style="display: none"
                             @endif class="mt-4">
                            @if(is_countable($variations) && count($variations) <= 1)
                                <input type="hidden" name="product_type" value="simple">
                            @else
                                <input type="hidden" name="product_type" value="variable">
                            @endif
                            <label class="block w-full hotel-text-color" for="options">Options</label>
                            <select id="options" name="variation_id">
                                @foreach($variations as $variation)
                                    <option value="{{$variation->id}}">{{$variation->name}} -
                                        £{{App\Helpers\Money::addTaxAndFormat($variation->price)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-input-label class="hotel-text-color text-xl" for="quantity" :value="__('Quantity')"/>
                            <div class="w-[100px]">
                                <x-number-input :key="'quantity'" :quantity="1"/>
                            </div>
                        </div>


                    </div>


                </div>
            </div>

            <div class="mt-4">

{{--                <details>--}}
{{--                    <summary><p class="cursor-pointer text-[#5a5a5a] text-xl font-bold">Select--}}
{{--                            when you would like this.</p></summary>--}}
                    <p class="hotel-text-color text-xl font-bold">Select when you would like this.</p>
                    <ul class="flex flex-wrap mt-4">
                        @php($i = 1)
                        @foreach ($dateArray as $date)
                            <li class="basis-full sm:basis-1/2 md:basis-1/3"><label
                                    class="border border-black bg-[#F7F7F7] rounded p-2 flex items-center mr-2 mb-2 basis-1/3 fancy-checkbox">
                                    <input @if($i == 1) checked @endif style="width: 0; height: 0; opacity: 0"
                                           name="dates[]" type="checkbox" value="{{ $date }}">
                                    <span class="w-[29px] h-[29px] border border-darkGrey rounded mr-2 relative"></span>
                                    <span></span>
                                    <span class="font-bold">Day {{$i}}</span>
                                    ({{ \Carbon\Carbon::parse($date)->format('jS M') }})</label></li>
                            @php($i++)
                        @endforeach
                    </ul>
{{--                </details>--}}
            </div>

            <x-primary-button class=" justify-center mt-4 w-full md:w-1/2 hotel-button-color hotel-button-text-color">Add to basket</x-primary-button>

            <span id="success"
                  class="hidden text-black hotel-accent-color-50 my-4 p-2 w-full block">Added to basket</span>

            <div class="mt-4 hotel-text-color">
                {{$product->description}}
            </div>
        </form>
    </div>
</x-guest-layout>
