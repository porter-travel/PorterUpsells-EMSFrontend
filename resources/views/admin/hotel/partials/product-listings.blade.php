@if(count($products) > 0)
    <ul class="sortable-list">
        @foreach($products as $key => $product)
            <li data-product-id="{{$product->id}}" class="sortable-item flex w-full items-center justify-start">
                <div draggable="true" class="handle cursor-grab">
                    <svg class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 8C10.3284 8 11 7.32843 11 6.5C11 5.67157 10.3284 5 9.5 5C8.67157 5 8 5.67157 8 6.5C8 7.32843 8.67157 8 9.5 8ZM9.5 14C10.3284 14 11 13.3284 11 12.5C11 11.6716 10.3284 11 9.5 11C8.67157 11 8 11.6716 8 12.5C8 13.3284 8.67157 14 9.5 14ZM11 18.5C11 19.3284 10.3284 20 9.5 20C8.67157 20 8 19.3284 8 18.5C8 17.6716 8.67157 17 9.5 17C10.3284 17 11 17.6716 11 18.5ZM15.5 8C16.3284 8 17 7.32843 17 6.5C17 5.67157 16.3284 5 15.5 5C14.6716 5 14 5.67157 14 6.5C14 7.32843 14.6716 8 15.5 8ZM17 12.5C17 13.3284 16.3284 14 15.5 14C14.6716 14 14 13.3284 14 12.5C14 11.6716 14.6716 11 15.5 11C16.3284 11 17 11.6716 17 12.5ZM15.5 20C16.3284 20 17 19.3284 17 18.5C17 17.6716 16.3284 17 15.5 17C14.6716 17 14 17.6716 14 18.5C14 19.3284 14.6716 20 15.5 20Z" fill="#121923"/>
                    </svg>
                </div>
                <div
                    class="flex flex-grow items-center justify-between border-b border-[#C4C4C4] py-2 @if($key == array_key_first($hotel->products->toArray())) border-t @endif">
                    <a class="flex items-center justify-start"
                       href="/admin/hotel/{{$hotel->id}}/product/{{$product->id}}/edit">
                        <div class="max-w-[70px] mr-4">
                            @include ('hotel.partials.product-image', ['item' => $product])
                        </div>

                        <p class="mr-2 text-xl">{{$product->name}}</p>
                    </a>
                    <div class="flex items-center justify-end">
                        <p class="mr-2">
                                    <span class="mr-4 py-2 px-4 rounded-full w-[100px] text-center inline-block
                                     @if($product->status == 'active') text-[#63B090] bg-[#D5F8E7] @elseif($product->status == 'inactive') text-[#C20000] bg-[#FFF5F5] @else text-darkGrey bg-grey @endif font-bold
                                     ">
                                    {{ucfirst($product->status)}}
                                        </span>
                            <x-money-display :amount="$product->price"
                                             :currency="auth()->user()->currency"/>
                        </p>


                        <a class="launchProductDeleteModal" data-hotel-id="{{$hotel->id}}"
                           data-product-id="{{$product->id}}" data-product-name="{{$product->name}}"
                           href="#">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink">
                                <circle cx="18" cy="18" r="18" fill="#C20000"/>
                                <rect x="6" y="6" width="24" height="24"
                                      fill="url(#pattern0_5506_7)"/>
                                <defs>
                                    <pattern id="pattern0_5506_7"
                                             patternContentUnits="objectBoundingBox"
                                             width="1" height="1">
                                        <use xlink:href="#image0_5506_7"
                                             transform="scale(0.0111111)"/>
                                    </pattern>
                                    <image id="image0_5506_7" width="90" height="90"
                                           xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB40lEQVR4nO2cS2rDQBBEtYpz8ijnyWLQhfK5RRmBDAaHENszPVXd9UDglal+SK0RGvWyGGOMMcYYY4wxxpgbAJwAvAP4Po7990lFFRTyA3gB8IFbNgCvCzkS+f8IyRdWNf8/QvKEVc1/R0hK2RL5HwhJJVsi/3F3bnicNvNuLpP/WPY8S5shu4PkC2tE2H2N2YMtso080S5+40dJdJjszpJ3PpeA0Cv60ka2kY7t4pq3UXlHB28jZCtljboUu7cRhYzyhYA4W5qCQJipC0yFgSjLEBgKBEGGEGYWiiqSZxaMapJnFI6qkiMFoLrkCBGw5LBH4DbgP7neeN/LoLOvdrsQlL2lkUwse0snmVB2XslEsvNLJpBdR/JE2fUkT5BdV3KgbEsOkG3J11h0AHDrSCH5Qt0WAi/vUkqud2bDj+AlJOc/s8EjOa9s8EnOJ5tYch7ZfjkbgLcbBOANNAF4S1gA3uQYgLftBsCwFw4EGYbCVCCIsnSFsTAQZnoK5oJAnC1dIRDImOazXwhlHTWvQ/2je6l5HcpjJKTmdWzCg1Fk5nU08VE/EvM6modXZRpnliW/xIC+LPklRk5myS8xRDVLfomxwFnyH6uRfen3dRyr0me/EM9vjDHGGGOMMcYYswRyBpias+umnbidAAAAAElFTkSuQmCC"/>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else

    <a href="/admin/hotel/{{$hotel->id}}/product/create"
       class="text-black font-bold">Add your first product</a>

@endif
