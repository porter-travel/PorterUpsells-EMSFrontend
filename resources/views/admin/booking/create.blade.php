<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Guest') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-[600px] mx-auto">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="{{route('booking.store', $hotel->id)}}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label class="text-black font-sans" for="guest_name" :value="__('Guest Name')"/>
                            <x-text-input id="guest_name" class="block mt-1 w-full p-4" type="text" name="guest_name" :value="old('guest_name')"
                                          required placeholder="Guest Name"/>
                            <x-input-error :messages="$errors->get('guest_name')" class="mt-2"/>
                        </div>

                        <div class="flex flex-wrap sm:flex-nowrap items-center justify-between max-w-[600px] mx-auto">
                            <div class="mt-2  basis-full sm:basis-1/2 sm:pr-2">
                                <x-input-label class="hotel-main-box-text-color open-sans" for="arrival-date" :value="__('Arrival Date')"/>
                                <x-text-input id="arrival-date" class="block mt-1 w-full p-4" type="date" name="arrival_date"
                                              :value="old('arrival_date')"
                                              required placeholder="Arrival Date"/>
                                <x-input-error :messages="$errors->get('arrival_date')" class="mt-2"/>
                            </div>

                            <div class="mt-2  basis-full sm:basis-1/2 sm:pl-2">
                                <x-input-label class="hotel-main-box-text-color open-sans" for="departure-date" :value="__('Departure Date')"/>
                                <x-text-input id="departure-date" class="block mt-1 w-full p-4" type="date" name="departure_date"
                                               :value="old('departure_date')"
                                              required placeholder="Departure Date"/>
                                <x-input-error :messages="$errors->get('departure_date')" class="mt-2"/>
                            </div>




                        </div>

                        <div class="mt-2 max-w-[600px] mx-auto ">
                            <x-input-label class="hotel-main-box-text-color open-sans" for="email-address" :value="__('Email Address')"/>
                            <x-text-input id="email-address" class="block mt-1 w-full p-4" type="email" name="email_address"
                                          :value="old('email_address')"
                                          required placeholder="Email Address"/>
                            <x-input-error :messages="$errors->get('email_address')" class="mt-2"/>
                        </div>

                        <div class="mt-2 max-w-[600px] mx-auto ">
                            <x-input-label class="hotel-main-box-text-color open-sans" for="email-address" :value="__('Booking Reference')"/>
                            <x-text-input id="email-address" class="block mt-1 w-full p-4" type="text" name="booking_ref"
                                          :value="old('booking_ref')"
                                           placeholder="Booking Reference"/>
                            <x-input-error :messages="$errors->get('booking_ref')" class="mt-2"/>
                        </div>

                        <div>
                            <label class="mt-2 block">
                            <input type="checkbox" name="send_email[]" value="now" checked> Send Email Now</label>
                            <label class="mt-2 block">
                                <input type="checkbox" name="send_email[]" value="30" checked> Send Email 30 Days Before Check in</label>
                            <label class="mt-2 block">
                                <input type="checkbox" name="send_email[]" value="7" checked> Send Email 7 Days Before Check in</label>
                            <label class="mt-2 block">
                                <input type="checkbox" name="send_email[]" value="2" checked> Send Email 2 Days Before Check in</label>
                        </div>



                        <x-primary-button class="w-full justify-center mt-4">Store Booking</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
