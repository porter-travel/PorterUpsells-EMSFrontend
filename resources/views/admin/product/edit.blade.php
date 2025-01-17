<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-extrabold open-sans text-2xl text-black leading-tight uppercase">
            {{ __('Edit Product: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="/admin/product/update"
                          id="productUpdateForm">

                        @csrf

                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="hotel_id" value="{{$hotel->id}}">

                        @include('admin.product.partials.core-fields', ['method' => 'update', 'product' => $product])


                        @include('admin.product.partials.specifics', ['method' => 'update'])


                        <div id="variantContainer">
                            <div class="my-6 flex items-center justify-between flex-wrap">
                                <h3 class="text-xl mr-4">Variations</h3>


                                <div>
                                    <button data-id="0"
                                            class="add-item flex items-center px-8 py-2 bg-mint rounded-full"
                                            role="button">
                                        <img style="pointer-events: none" src="/img/icons/plus.svg" alt="add" class="mr-2">
                                        Add a variation
                                    </button>
                                </div>
                            </div>

                            <div id="variations-list" class="@if(count($product->variations) == 1) hidden @endif">
                                @foreach($product->variations as $key => $variation)
                                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-[#C4C4C4]">

                                        <input type="hidden" name="variants[{{$key}}][variant_id]"
                                               value="{{$variation->id}}">
                                        <div class="">
                                            <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                                   for="name">Name</label>
                                            <input value="{{$variation->name}}"
                                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full px-3 py-2"
                                                   id="name" type="text" name="variants[{{$key}}][variant_name]"
                                                   required="required" placeholder="Name">
                                        </div>

                                        <div class="">
                                            <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                                   for="price">Price</label>
                                            <input value="{{$variation->price}}"
                                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full px-3 py-2"
                                                   id="price" type="number" step=".01"
                                                   name="variants[{{$key}}][variant_price]" required="required"
                                                   placeholder="12.34">
                                        </div>

                                        <div class="">
                                            <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                                   for="image">Image</label>
                                            <img src="{{$variation->image}}" alt="product"
                                                 class="w-[100px] rounded-3xl mb-2"/>
                                            <input type="file" name="variants[{{$key}}][variant_image]" id="image">
                                        </div>

                                        <div>
                                            <button class="remove-item delete-item" role="button"
                                                    data-remove-id="{{$variation->id}}"><img
                                                    style="pointer-events: none" src="/img/icons/remove.svg"
                                                    alt="remove">
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Update Product</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('admin.product.partials.unavailability-modal', ['product' => $product])

</x-hotel-admin-layout>
