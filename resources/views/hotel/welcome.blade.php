<x-guest-layout>
    <div class="mt-20">
        <div class="bg-blue px-8 pt-20 pb-12 max-w-[500px] mx-auto rounded-3xl relative">
            <div class="absolute -top-10 bg-gold px-4 py-6 left-1/2 -translate-x-1/2 rounded-3xl">
                <img style="width: 80px; height: 60px; object-fit: contain" src="{{$hotel->logo}}" alt="hotel"
                     class=""/>
            </div>

            <p class="text-white text-center font-sans">
                Enter your booking details to personalise your upcoming stay
            </p>

            <form method="post" action="/createSession">

                <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                @csrf
                <div class="mt-4">
                    <x-input-label class="text-white font-sans" for="name" :value="__('Name')"/>
                    <x-text-input id="name" class="block mt-1 w-full p-4" type="text" name="name"
                                  :value="$name ?: old('name')"
                                  required placeholder="Name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-input-label class="text-white font-sans" for="booking-ref" :value="__('Booking Reference')"/>
                    <x-text-input id="booking-ref" class="block mt-1 w-full p-4" type="text" name="booking_ref"
                                  :value="$booking_ref ?: old('booking_ref')"
                                  required placeholder="Booking reference"/>
                    <x-input-error :messages="$errors->get('booking_ref')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-input-label class="text-white font-sans" for="arrival-date" :value="__('Arrival Date')"/>
                    <x-text-input id="arrival-date" class="block mt-1 w-full p-4" type="date" name="arrival_date"
                                  :value="$arrival_date ?: old('arrival_date')"
                                  required placeholder="Arrival Date"/>
                    <x-input-error :messages="$errors->get('arrival_date')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-input-label class="text-white font-sans" for="email-address" :value="__('Email Address')"/>
                    <x-text-input id="email-address" class="block mt-1 w-full p-4" type="email" name="email_address"
                                  :value="$email_address ?: old('email_address')"
                                  required placeholder="Email Address"/>
                    <x-input-error :messages="$errors->get('email_address')" class="mt-2"/>
                </div>
                <x-primary-button class="w-full justify-center mt-4">Personalise my stay</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
