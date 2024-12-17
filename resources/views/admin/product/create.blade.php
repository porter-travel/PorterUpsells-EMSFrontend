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

                        @include('admin.product.partials.core-fields', ['product' => new \App\Models\Product()])


                        @include('admin.product.partials.specifics', ['method' => 'create'])


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

                            <div id="variations-list" class="hidden">
                            </div>



                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Add Product</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>
