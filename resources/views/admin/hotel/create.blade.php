<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Hotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="/admin/hotel/create">
                        @csrf
                        <div class="mt-4">
                            <x-input-label class="text-white font-sans" for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full p-4" type="text" name="name" :value="old('name')"
                                          required placeholder="Name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label class="text-white font-sans" for="name" :value="__('Address')"/>
                            <x-text-input id="address" class="block mt-1 w-full p-4" type="text" name="address" :value="old('address')"
                                          required placeholder="Address"/>
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="logo" :value="__('Logo')"/>
                            <input type="file" name="logo" id="logo">
                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Add Hotel</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
