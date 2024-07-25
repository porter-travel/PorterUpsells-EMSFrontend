<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <img src="{{$hotel->logo}}" alt="hotel" class="h-[70px] rounded-3xl mr-2"/>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $hotel->name }}
                </h2>
            </div>
            <div>
                <p id="confirmation-text">Your hotel link</p>
                <input id="hotel-welcome-url" type="text" disabled
                       value="{{env('APP_URL')}}/hotel/{{$hotel->slug}}/welcome">
                <span class="copy-label cursor-pointer" onclick="copyToClipboard()">Copy</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-bold mr-2">Products</h2>
                        <a href="/admin/hotel/{{$hotel->id}}/product/create"
                           class="text-black font-bold border rounded-xl p-4 hover:bg-mint">Add Product + </a>
                    </div>
                    @if(count($hotel->products) > 0)

                        @foreach($hotel->products as $product)
                            <div class="flex items-center justify-between mb-2 border-b border-b-black py-1">
                                <a class="flex items-center justify-start"
                                   href="/admin/hotel/{{$hotel->id}}/product/{{$product->id}}/edit">
                                    <div class="max-w-[70px] mr-4">
                                        @include ('hotel.partials.product-image', ['item' => $product])
                                    </div>

                                    <p class="mr-2">{{$product->name}}</p>
                                </a>

                                <p class="mr-2">
                                    <x-money-display :amount="$product->price" :currency="auth()->user()->currency"/>
                                </p>
                            </div>

                        @endforeach

                    @else

                        <a href="/admin/hotel/{{$hotel->id}}/product/create"
                           class="text-black font-bold">Add your first product</a>

                    @endif

                </div>

            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Hotel Details</h2>
                    <form enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
                        @csrf
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full p-4" type="text" name="name"
                                          :value="$hotel->name"
                                          required placeholder="Name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="address" :value="__('Address')"/>
                            <x-text-input id="address" class="block mt-1 w-full p-4" type="text" name="address"
                                          :value="$hotel->address"
                                          required placeholder="Address"/>
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="email_address"
                                           :value="__('Email Address')"/>
                            <x-text-input id="email_address" class="block mt-1 w-full p-4" type="text"
                                          name="email_address"
                                          :value="$hotel->email_address"
                                          required placeholder="Email Address"/>
                            <x-input-error :messages="$errors->get('email_address')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="email_address"
                                           :value="__('Hotel ID Within Integration Partner')"/>
                            <x-text-input id="email_address" class="block mt-1 w-full p-4" type="text"
                                          name="id_for_integration"
                                          :value="$hotel->id_for_integration"
                                          required placeholder="Integration Partner ID"/>
                            <x-input-error :messages="$errors->get('id_for_integration')" class="mt-2"/>
                        </div>


                        <x-primary-button class="w-full justify-center mt-4">Update</x-primary-button>

                    </form>
                    <form enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
                        @csrf
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="logo" :value="__('Logo')"/>
                            <input type="file" name="logo" id="logo" value="{{$hotel->logo}}">
                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Update Logo</x-primary-button>
                    </form>

                    <form enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
                        @csrf
                        <div class="mt-4">
                            <div class="mt-4">
                                <x-input-label class="text-black font-sans" for="featured_image"
                                               :value="__('Featured Image')"/>
                                <input type="file" name="featured_image" id="featured_image">
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Update Featured Image</x-primary-button>
                    </form>

                    <form method="post" action="/admin/hotel/{{$hotel->id}}/update">

                        @include('admin.hotel.partials.colour-scheme', ['hotel' => $hotel])

                        <x-primary-button class="w-full justify-center mt-4">Update Hotel Colour Scheme
                        </x-primary-button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
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
</x-app-layout>
