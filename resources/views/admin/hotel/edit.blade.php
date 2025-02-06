<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <img src="{{$hotel->logo}}" alt="hotel" class="h-[70px] rounded-3xl mr-2"/>
                <h2 class="font-extrabold open-sans text-2xl text-black leading-tight uppercase">
                    {{ $hotel->name }}
                </h2>
            </div>
            <div>
                <p id="confirmation-text" class="open-sans font-semibold">Your upsell link</p>
                <div class="flex items-center">
                    <input id="hotel-welcome-url" type="text" disabled class="border-darkGrey/50 rounded-lg mr-4"
                           value="{{env('APP_URL')}}/hotel/{{$hotel->slug}}/welcome">
                    <span class="copy-label cursor-pointer flex px-8 py-2 bg-[#E4E4E4] rounded-full"
                          onclick="copyToClipboard()">
                    <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.93103 6.92931H20.069C21.1745 6.92931 22.0707 7.82551 22.0707 8.93103V20.069C22.0707 21.1745 21.1745 22.0707 20.069 22.0707H8.93103C7.82551 22.0707 6.92931 21.1745 6.92931 20.069V8.93103C6.92931 7.82551 7.82551 6.92931 8.93103 6.92931ZM8.93103 5.95C7.28465 5.95 5.95 7.28465 5.95 8.93103V20.069C5.95 21.7153 7.28465 23.05 8.93103 23.05H20.069C21.7153 23.05 23.05 21.7153 23.05 20.069V8.93103C23.05 7.28465 21.7153 5.95 20.069 5.95H8.93103Z"
                            fill="black" stroke="black" stroke-width="0.1"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M2.33657 2.73583C1.97476 3.23834 1.85 3.85412 1.85 4.25833V14.7417C1.85 15.3848 1.99401 15.8337 2.19577 16.1523C2.39751 16.4708 2.67517 16.6877 2.98897 16.8371C3.63506 17.1448 4.3929 17.15 4.825 17.15V18L4.80907 18C4.38355 18.0001 3.45442 18.0002 2.62353 17.6045C2.19358 17.3998 1.78061 17.0854 1.47767 16.6071C1.17474 16.1288 1 15.5152 1 14.7417V4.25833C1 3.7181 1.15857 2.91721 1.64676 2.23917C2.15056 1.53946 2.98648 1 4.25833 1H14.7417C15.2819 1 16.0828 1.15857 16.7608 1.64676C17.4605 2.15056 18 2.98648 18 4.25833V5.10833H17.15V4.25833C17.15 3.26352 16.745 2.68277 16.2642 2.33657C15.7617 1.97476 15.1459 1.85 14.7417 1.85H4.25833C3.26352 1.85 2.68277 2.25499 2.33657 2.73583Z"
                              fill="black" stroke="black" stroke-width="0.3"/>
                    </svg>

                    Copy</span>

                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="py-6 text-gray-900">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="font-extrabold open-sans text-2xl text-black leading-tight uppercase">Products</h2>
                        <details class="relative z-10">
                            <summary
                                class="flex items-center px-12 py-2 bg-mint rounded-full cursor-pointer">
                                <svg class="mr-2" width="30" height="30" viewBox="0 0 30 30" fill="none"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="30" height="30" fill="url(#pattern0_5476_1518)"/>
                                    <defs>
                                        <pattern id="pattern0_5476_1518" patternContentUnits="objectBoundingBox"
                                                 width="1"
                                                 height="1">
                                            <use xlink:href="#image0_5476_1518" transform="scale(0.0111111)"/>
                                        </pattern>
                                        <image id="image0_5476_1518" width="90" height="90"
                                               xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD2klEQVR4nO2dSY9NURDHf4mhW0xb3S1B8AUMK4QItlggMQWNDYkp7VnaGVbSia9hXBA+ABHSho0NNobQupsVkubIkSK89H3p1ufcqntf/ZLa3Lz3UvV/N+fUqVvnXHAcx3Ecx3Ecx3HGzRRgJdALXASuAU+BF8Aw8E1sWK49lc9ckO+skN9wxmA+cBy4CXwGwiTtE3ADOAb00ObMAPYAd4HvCcQtslHgDrAb6KSNmCV32puM4hbZB+AsMJcaMw3oA4YUBG626MMp8alWrAGeGRC42Z4DG6gBcUy8DPwwIGqRRd/6gQ4qykLgvgEhwzjtEbCEirEhUZoWSraYFq6nImwFvhgQLfynxcXQDoxzOHNOHEqyGMMhjLJFFgfaIoWEYm/HGHFc+2pAnJBhGNmEEZZWdOILE5ggF2uL3CFpUai5PdTOsy8bECGUZHFRo7astrziC4ktxrq2bJGnAk8MBB9KtmdlF6L6lDKAPqBL7LRcK9uPE2WJPFup1Hl6DF8aCn4MSk09OxrBBbmLm5mn5EusZWcve75VCq4IDV/eyaO4bOxVCiy08EnLn505hY4PUl1ofmlwK5fIPcpFoyI0i05ZWhmOKwYVWvil6dPRHELH5hYXmn80uJJa5NhiNeJC03yjjaRuP1upfDeHFr5p+7U8pdAHDQRUhLZf+0nIRQMBFaHt1zkSct1AQEWEOk2IFkqiRWj7NUBCXmUodWqRusT6MqVzHzOWOrVoJCybJiPVv9+FHVKVWGObhTmhu7FDj0WhUw0dDexwxuLQkXIybCjf2d3ig8nJ0NM7yknvfMFCOQsWX4JTzhK8N9F4FiZhRWj7tS+l0F4mpVDoZSmF9sI/5RT+kb3VPnSQbyL8TdxW7ELzjwZHciX63m7AH5FHpV6ShXhKgGcd5G2gQY59cKHJ3xLWqXT8Q2jhUy2bHLWa0ENBISpVqXOidpIaN6I3MpY6J1oWnUlJnFII8NtfJdbUpc6JWExzS90s9FghyNBum4Uiq337W3n0G7jLQkl2CUU6ZPtuqLk9AKajzGLZmB5qaiPAIoywruKnzoQCi1nNRoyxuYYHo2zDKIdqctTPqPSEm2ZLxYeRrxaP+Gl19M+nik5866gYC4B7BsQL47SHFo70mUye3W98BflDFiPqeXKq5foTA6I2W/RpFTVjqhwqMmhA4EGpwkWfastMCfK1gsDv5aDuObQRncAu4Hbmhc6oPEjd2W5Hz49Fl2xgvypvo5isuMPyW0dytgRUnSnSz3YAOC/dQAPyKpChv14PMiTXBuQz52UXa/yuvx7EcRzHcRzHcRyHcfITiV5ZbaaGSxIAAAAASUVORK5CYII="/>
                                    </defs>
                                </svg>
                                Add a Product
                            </summary>
                            <div
                                class="content absolute bg-mint w-full top-[20px] pt-12 pb-4 rounded-b-[20px] -z-10">
                                <ul class="list-none">
                                    <li class="pl-12 border-b border-darkGrey py-2"><a
                                            href="/admin/hotel/{{$hotel->id}}/product/create/standard">Standard
                                            Product</a></li>
                                    <li class="pl-12 border-b border-darkGrey py-2">
                                        <a href="/admin/hotel/{{$hotel->id}}/product/create/calendar">
                                            Calendar Product
                                        </a>
                                    </li>
                                    @if($hotel->property_type == 'hotel')
                                        <li class="pl-12 border-b border-darkGrey py-2">
                                            <a href="/admin/hotel/{{$hotel->id}}/product/create/restaurant">
                                            <span style="color: grey">Restaurant
                                            Booking (coming soon)</span>
                                            </a>
                                        </li>
                                    @endif


                                </ul>
                            </div>
                        </details>
                    </div>
                    @if(count($hotel->products) > 0)

                        @foreach($hotel->products as $key => $product)
                            <div
                                class="flex items-center justify-between border-b border-[#C4C4C4] py-2 @if($key == array_key_first($hotel->products->toArray())) border-t @endif">
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
                                            <rect x="6" y="6" width="24" height="24" fill="url(#pattern0_5506_7)"/>
                                            <defs>
                                                <pattern id="pattern0_5506_7" patternContentUnits="objectBoundingBox"
                                                         width="1" height="1">
                                                    <use xlink:href="#image0_5506_7" transform="scale(0.0111111)"/>
                                                </pattern>
                                                <image id="image0_5506_7" width="90" height="90"
                                                       xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB40lEQVR4nO2cS2rDQBBEtYpz8ijnyWLQhfK5RRmBDAaHENszPVXd9UDglal+SK0RGvWyGGOMMcYYY4wxxpgbAJwAvAP4Po7990lFFRTyA3gB8IFbNgCvCzkS+f8IyRdWNf8/QvKEVc1/R0hK2RL5HwhJJVsi/3F3bnicNvNuLpP/WPY8S5shu4PkC2tE2H2N2YMtso080S5+40dJdJjszpJ3PpeA0Cv60ka2kY7t4pq3UXlHB28jZCtljboUu7cRhYzyhYA4W5qCQJipC0yFgSjLEBgKBEGGEGYWiiqSZxaMapJnFI6qkiMFoLrkCBGw5LBH4DbgP7neeN/LoLOvdrsQlL2lkUwse0snmVB2XslEsvNLJpBdR/JE2fUkT5BdV3KgbEsOkG3J11h0AHDrSCH5Qt0WAi/vUkqud2bDj+AlJOc/s8EjOa9s8EnOJ5tYch7ZfjkbgLcbBOANNAF4S1gA3uQYgLftBsCwFw4EGYbCVCCIsnSFsTAQZnoK5oJAnC1dIRDImOazXwhlHTWvQ/2je6l5HcpjJKTmdWzCg1Fk5nU08VE/EvM6modXZRpnliW/xIC+LPklRk5myS8xRDVLfomxwFnyH6uRfen3dRyr0me/EM9vjDHGGGOMMcYYswRyBpias+umnbidAAAAAElFTkSuQmCC"/>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        @endforeach

                    @else

                        <a href="/admin/hotel/{{$hotel->id}}/product/create"
                           class="text-black font-bold">Add your first product</a>

                    @endif

                </div>

            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Property Details</h2>
                    <form enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
                        @csrf
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full px-3 py-2" type="text" name="name"
                                          :value="$hotel->name"
                                          required placeholder="Name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="address" :value="__('Address')"/>
                            <x-text-input id="address" class="block mt-1 w-full px-3 py-2" type="text" name="address"
                                          :value="$hotel->address"
                                          required placeholder="Address"/>
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="email_address"
                                           :value="__('Email Address')"/>
                            <x-text-input id="email_address" class="block mt-1 w-full px-3 py-2" type="text"
                                          name="email_address"
                                          :value="$hotel->email_address"
                                          required placeholder="Email Address"/>
                            <x-input-error :messages="$errors->get('email_address')" class="mt-2"/>
                        </div>
                        @if($hotel->property_type == 'hotel')
                            <div class="mt-4">
                                <div class="flex items-start justify-start flex-wrap">
                                    <div class="lg:basis-1/2 basis-full pr-4">
                                        <x-input-label class="text-black font-sans" for="integration_name"
                                                       :value="__('PMS Name')"/>
                                        <select id="integration_name" name="integration_name"
                                                class="border-[#C4C4C4] rounded-md w-full">
                                            <option></option>
                                            <option @if($hotel->integration_name == 'zonal') selected
                                                    @endif value="zonal">
                                                Zonal / High Level Software
                                            </option>
                                        </select>

                                    </div>
                                    <div class="lg:basis-1/2 basis-full">
                                        <x-input-label class="text-black font-sans" for="id_for_integration"
                                                       :value="__('Hotel PMS ID')"/>
                                        <x-text-input id="id_for_integration" class="block mt-1 w-full px-3 py-2"
                                                      type="text"
                                                      name="id_for_integration"
                                                      :value="$hotel->id_for_integration"
                                                      placeholder="Integration Partner ID"/>
                                        <x-input-error :messages="$errors->get('id_for_integration')" class="mt-2"/>
                                    </div>
                                </div>

                                <div class=" mt-4 basis-full">
                                    <x-input-label class="text-black font-sans" for="resdiary_microsite_name"
                                                   :value="__('ResDiary Microsite Name')"/>
                                    <x-text-input id="resdiary_microsite_name" class="block mt-1 w-full px-3 py-2"
                                                  type="text"
                                                  name="resdiary_microsite_name"
                                                  :value="$resdiary_microsite_name"
                                                  placeholder="EnhanceMyStay"/>
                                    <x-input-error :messages="$errors->get('resdiary_microsite_name')" class="mt-2"/>
                                </div>
                                @endif
                                <div class="text-right">
                                    <x-primary-button dusk="update-hotel-details" class=" mt-4">Update
                                    </x-primary-button>
                                </div>
                            </div>
                    </form>
                    <form class="border-t border-[#C4C4C4] mt-4 pt-4 flex items-end justify-between"
                          enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
                        @csrf
                        <div class="flex items-end justify-start">
                            <div class="mr-12">
                                <p class="open-sans text-2xl mb-6">Logo</p>
                                <img src="{{$hotel->logo}}" alt="hotel" class="h-[70px] rounded-3xl mr-2"/>
                            </div>

                            <div class="mt-4">
                                <x-input-label class="text-black font-sans sr-only" for="logo" :value="__('Logo')"/>
                                <input type="file" name="logo" id="logo" value="{{$hotel->logo}}">
                            </div>
                        </div>
                        <div>
                            <x-primary-button class=" mt-4">Update</x-primary-button>
                        </div>
                    </form>

                    <form class="border-t border-[#C4C4C4] mt-4 pt-4 flex items-end justify-between"
                          enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
                        @csrf
                        <div class="flex items-end justify-start">
                            <div class="mr-12">
                                <p class="open-sans text-2xl mb-6">Cover Image</p>
                                <img alt="current featured image" class="w-[140px] h-auto"
                                     src="{{$hotel->featured_image}}">
                            </div>
                            <x-input-label class="text-black font-sans sr-only" for="featured_image"
                                           :value="__('Featured Image')"/>
                            <input type="file" name="featured_image" id="featured_image">
                        </div>
                        <div>
                            <x-primary-button class="mt-4">Update</x-primary-button>
                        </div>
                    </form>

                    <form class="border-t border-[#C4C4C4] mt-4 pt-4 " method="post"
                          action="/admin/hotel/{{$hotel->id}}/update">

                        @include('admin.hotel.partials.colour-scheme', ['hotel' => $hotel])
                        <div class="text-right">
                            <x-primary-button class=" mt-4">Update
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="productDeleteModalContainer hidden fixed bg-black/50 inset-0 z-50">

        <div class="fixed top-10 left-1/2 -translate-x-1/2 bg-white rounded-2xl p-8">
            <form method="post" action="">
                @csrf
                <h4>Are you sure you want to delete <span id="productToDeleteName"></span></h4>
                <div class="flex items-center justify-between">
                    <x-secondary-button dusk="cancel-delete-product" class="mt-4">No</x-secondary-button>
                    <x-danger-button dusk="confirm-delete-product" class="mt-4">Yes</x-danger-button>
                </div>
            </form>
        </div>

    </div>


    <script>

        document.addEventListener("DOMContentLoaded", () => {
            // Select all links with the class "launchProductDeleteModal"
            const deleteLinks = document.querySelectorAll(".launchProductDeleteModal");
            const modal = document.querySelector(".productDeleteModalContainer");
            const productNameSpan = document.getElementById("productToDeleteName");
            const form = modal.querySelector("form");
            const cancelButton = modal.querySelector("[dusk='cancel-delete-product']");

            deleteLinks.forEach(link => {
                link.addEventListener("click", (event) => {
                    event.preventDefault(); // Prevent the default link behavior

                    // Extract data attributes
                    const hotelId = link.getAttribute("data-hotel-id");
                    const productId = link.getAttribute("data-product-id");
                    const productName = link.getAttribute("data-product-name");

                    // Update modal content and action
                    modal.classList.remove("hidden");
                    productNameSpan.textContent = productName;
                    form.action = `/admin/hotel/${hotelId}/product/${productId}/delete`;
                });
            });

            cancelButton.addEventListener("click", (event) => {
                event.preventDefault(); // Prevent button default behavior
                modal.classList.add("hidden");
            });
        });


        function copyToClipboard() {
            var copyText = document.getElementById("hotel-welcome-url");
            var confirmationText = document.getElementById("confirmation-text");

            // Create a temporary input to hold the text
            var tempInput = document.createElement("input");
            tempInput.value = copyText.value;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the temporary input
            document.execCommand("copy");

            // Remove the temporary input
            document.body.removeChild(tempInput);

            // Update the confirmation text
            confirmationText.textContent = "Link copied to clipboard!";
            confirmationText.classList.add("confirmation");

            // Optionally, you can revert the confirmation text after a few seconds
            setTimeout(function () {
                confirmationText.textContent = "Your hotel link";
                confirmationText.classList.remove("confirmation");
            }, 3000);
        }
    </script>
</x-hotel-admin-layout>
