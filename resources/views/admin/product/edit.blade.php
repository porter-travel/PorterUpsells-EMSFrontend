<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="/admin/product/update"
                          id="productUpdateForm">

                        @csrf

                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="name" value="Name"/>
                            <x-text-input id="name" class="block mt-1 w-full p-4" type="text" name="name"
                                          :value="$product->name"
                                          required placeholder="Name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="price" :value="__('Price')"/>
                            <x-text-input id="price" class="block mt-1 w-full p-4" type="number" name="price"
                                          :value="$product->price"
                                          required step=".01" placeholder="12.34"/>
                            <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="name" :value="__('Description')"/>
                            <textarea id="description" class="block mt-1 w-full p-4 rounded-md" type="text"
                                      name="description"
                                      required>{{$product->description}}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <img src="{{$product->image}}" alt="product" class="w-[200px] rounded-3xl mb-2"/>
                                </div>
                                <x-input-label class="text-black font-sans" for="image" :value="__('Update Image')"/>
                                <input type="file" name="image" id="image">
                            </div>
                        </div>


                        <div id="variantContainer">
                            <div class="my-6 flex items-center justify-start flex-wrap">
                                <h3 class="text-xl mr-4">Variations</h3>


                                <div>
                                    <button data-id="0" class="add-item" role="button">Add a variation</button>
                                </div>

                                <small class="basis-full">Each product must have at least 1 variation, even if this is
                                    the same as the product. If there is a single variation here, removing it will
                                    simply copy the data from the product and replace it on next save</small>
                            </div>


                            @foreach($product->variations as $key => $variation)
                                <div class="flex items-center justify-between">

                                    <input type="hidden" name="variants[{{$key}}][variant_id]"
                                           value="{{$variation->id}}">
                                    <div class="">
                                        <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                               for="name">Name</label>
                                        <input value="{{$variation->name}}"
                                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full p-4"
                                               id="name" type="text" name="variants[{{$key}}][variant_name]"
                                               required="required" placeholder="Name">
                                    </div>

                                    <div class="">
                                        <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                               for="price">Price</label>
                                        <input value="{{$variation->price}}"
                                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full p-4"
                                               id="price" type="number" step=".01"
                                               name="variants[{{$key}}][variant_price]" required="required"
                                               placeholder="12.34">
                                    </div>

                                    <div class="">
                                        <img src="{{$variation->image}}" alt="product"
                                             class="w-[100px] rounded-3xl mb-2"/>
                                        <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                               for="image">Image</label>
                                        <input type="file" name="variants[{{$key}}][variant_image]" id="image">
                                    </div>

                                    <div>
                                        <button data-id="${id}" class="add-item" role="button">Add</button>
                                        <button class="remove-item delete-item" role="button"
                                                data-remove-id="{{$variation->id}}">Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Update Product</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
