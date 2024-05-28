<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start">
            <img src="{{$hotel->logo}}" alt="hotel" class="h-[70px] rounded-3xl mr-2"/>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $hotel->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex items-end justify-start">
                        <h2 class="text-2xl font-bold mr-2">Products</h2>
                        <a href="/admin/hotel/{{$hotel->id}}/product/create"
                           class="text-black font-bold">Add Product</a>
                    </div>
                    @if(count($hotel->products) > 0)

                        @foreach($hotel->products as $product)
                            <div class="flex items-center justify-between mb-2 border-b border-b-black py-1">
                                    <a class="flex items-center justify-start" href="/admin/hotel/{{$hotel->id}}/product/{{$product->id}}/edit">
                                <img src="{{$product->image}}" alt="product" class="h-[70px] rounded-3xl mr-2"/>
                                <p class="mr-2">{{$product->name}}</p>
                                    </a>
                                <p class="mr-2">£{{$product->price}}</p>
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
                            <x-input-label class="text-black font-sans" for="name" :value="__('Address')"/>
                            <x-text-input id="address" class="block mt-1 w-full p-4" type="text" name="address"
                                          :value="$hotel->address"
                                          required placeholder="Address"/>
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
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
                                <x-input-label class="text-black font-sans" for="featured_image" :value="__('Featured Image')"/>
                                <input type="file" name="featured_image" id="featured_image">
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Update Featured Image</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
