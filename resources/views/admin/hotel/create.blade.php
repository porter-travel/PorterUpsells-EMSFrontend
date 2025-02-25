<x-hotel-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Property') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="/admin/hotel/create">
                        @csrf
                        <div class="mt-4">
                            <div class="flex flex-wrap">
                                <div class="md:basis-1/2 md:pr-4 basis-full">
                                    <x-input-label class=" font-sans" for="name" :value="__('Name')"/>
                                    <x-text-input dusk="hotel-name" id="name" class="block mt-1 w-full" type="text"
                                                  name="name" :value="old('name')"
                                                  required placeholder="Name"/>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                </div>
                                <div class="md:basis-1/2 md:pl-4 basis-full">
                                    <x-input-label class=" font-sans" for="property-type" :value="__('Property Type (Coming Soon)')"/>
                                    <input type="hidden" name="property_type" value="hotel">
                                    <select disabled name="property_type" id="property-type" class="border-[#C4C4C4] rounded-md w-full">
                                        <option value="hotel">Hotel</option>
                                        <option value="restaurant">Restaurant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label class=" font-sans" for="name" :value="__('Address')"/>
                            <x-text-input dusk="hotel-address" id="address" class="block mt-1 w-full " type="text"
                                          name="address" :value="old('address')"
                                          required placeholder="Address"/>
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="logo" :value="__('Logo')"/>
                            <input dusk="hotel-logo" required type="file" name="logo" id="logo">
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="featured_image"
                                           :value="__('Featured Image')"/>
                            <input type="file" name="featured_image" id="featured_image">
                        </div>
                        <div class="text-right">
                            <x-primary-button dusk="create-hotel" class=" justify-center mt-4">Add Hotel
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-hotel-admin-layout>
