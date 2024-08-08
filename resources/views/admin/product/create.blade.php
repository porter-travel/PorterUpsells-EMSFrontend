<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="/admin/product/store">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{$hotel->id}}">

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="status" :value="__('Status')"/>
                            <select name="status" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full p-4" type="text" name="name"
                                          :value="old('name')"
                                          required placeholder="Name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="price"
                                           :value="__('Price (' . \App\Helpers\Money::lookupCurrencySymbol(auth()->user()->currency) . ')')"/>
                            <x-text-input id="price" class="block mt-1 w-full p-4" type="number" name="price"
                                          :value="old('price')"
                                          required step=".01" placeholder="12.34"/>
                            <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="name" :value="__('Description')"/>
                            <textarea id="description" class="block mt-1 w-full p-4 rounded-md" type="text"
                                      name="description" value="{{old('description')}}"
                                      required></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="image" :value="__('Image')"/>
                            <input type="file" required name="image" id="image">
                        </div>

                        @include('admin.product.partials.specifics')


                        <div id="variantContainer">
                            <div class="my-6 flex items-center justify-start">
                                <h3 class="text-xl mr-4">Variations</h3>

                                <div>
                                    <button data-id="0" class="add-item" role="button">Add a variation</button>
                                </div>
                            </div>




                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Add Product</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
