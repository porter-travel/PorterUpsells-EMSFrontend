<div class="hotel-main-box-color box-shadow px-8 pt-8 pb-8 max-w-[667px] mx-auto rounded-3xl relative">
    <form method="post" action="/set-user-stay-dates">
        @csrf
        <p class="hotel-main-box-text-color font-bold text-left open-sans text-lg">
            {{$date_picker_title}}
        </p>
        <div class="flex flex-wrap sm:flex-nowrap items-end justify-between max-w-[600px] mx-auto">
{{--{{var_dump($specifics)}}--}}
            @if(!isset($specifics['on_arrival']) || (isset($specifics['on_arrival']) && $specifics['on_arrival']) || (isset($specifics['during_stay']) && $specifics['during_stay']))
                <div class="mt-2  basis-full sm:basis-1/2 sm:pr-2">
                    <x-input-label class="hotel-main-box-text-color open-sans" for="arrival-date"
                                   :value="__('Arrival Date')"/>
                    <x-text-input id="arrival-date" class="block mt-1 w-full p-2" type="date" name="arrival_date"
                                  :value="$arrival_date ?: old('arrival_date')"
                                  required placeholder="Arrival Date"/>
                    <x-input-error :messages="$errors->get('arrival_date')" class="mt-2"/>
                </div>
            @endif

            @if((isset($specifics['on_departure']) && $specifics['on_departure']) || (isset($specifics['during_stay']) && $specifics['during_stay']))
                <div class="mt-2  basis-full sm:basis-1/2 sm:pl-2">
                    <x-input-label class="hotel-main-box-text-color open-sans" for="departure-date"
                                   :value="__('Departure Date')"/>
                    <x-text-input id="departure-date" class="block mt-1 w-full p-2" type="date" name="departure_date"
                                  :value="$departure_date ?: old('departure_date')"
                                  required placeholder="Departure Date"/>
                    <x-input-error :messages="$errors->get('departure_date')" class="mt-2"/>
                </div>
            @endif


        </div>
        <x-secondary-button type="submit" class="w-full justify-center mt-4 hotel-button-color hotel-button-text-color">Save
        </x-secondary-button>
    </form>
</div>
