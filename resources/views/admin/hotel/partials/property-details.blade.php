<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="py-6 text-gray-900">
        <h2 class="text-2xl font-bold mb-6">Property Details</h2>
        <form enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
            @csrf
            <div class="mt-4">
                <x-input-label class="text-black font-sans" for="name" :value="__('Name')"/>
                <x-text-input id="name" class="block mt-1 w-full px-3 py-2" type="text" name="name"
                              :value="$hotel->name"
                              required placeholder="Name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input-label class="text-black font-sans" for="address" :value="__('Address')"/>
                <x-text-input id="address" class="block mt-1 w-full px-3 py-2" type="text" name="address"
                              :value="$hotel->address"
                              required placeholder="Address"/>
                <x-input-error :messages="$errors->get('address')" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-input-label class="text-black font-sans" for="email_address"
                               :value="__('Email Address')"/>
                <x-text-input id="email_address" class="block mt-1 w-full px-3 py-2" type="text"
                              name="email_address"
                              :value="$hotel->email_address"
                              required placeholder="Email Address"/>
                <x-input-error :messages="$errors->get('email_address')" class="mt-2"/>
            </div>
            @if($hotel->property_type == 'hotel')
            <div class="mt-4">
                <div class="flex items-start justify-start flex-wrap">
                    <div class="lg:basis-1/2 basis-full pr-4">
                        <x-input-label class="text-black font-sans" for="integration_name"
                                       :value="__('PMS Name')"/>
                        <select id="integration_name" name="integration_name"
                                class="border-[#C4C4C4] rounded-md w-full">
                            <option></option>
                            <option @if($hotel->integration_name == 'zonal') selected
                                @endif value="zonal">
                                Zonal / High Level Software
                            </option>
                        </select>

                    </div>
                    <div class="lg:basis-1/2 basis-full">
                        <x-input-label class="text-black font-sans" for="id_for_integration"
                                       :value="__('Hotel PMS ID')"/>
                        <x-text-input id="id_for_integration" class="block mt-1 w-full px-3 py-2"
                                      type="text"
                                      name="id_for_integration"
                                      :value="$hotel->id_for_integration"
                                      placeholder="Integration Partner ID"/>
                        <x-input-error :messages="$errors->get('id_for_integration')" class="mt-2"/>
                    </div>
                </div>

                <div class=" mt-4 basis-full">
                    <x-input-label class="text-black font-sans" for="resdiary_microsite_name"
                                   :value="__('ResDiary Microsite Name')"/>
                    <x-text-input id="resdiary_microsite_name" class="block mt-1 w-full px-3 py-2"
                                  type="text"
                                  name="resdiary_microsite_name"
                                  :value="$resdiary_microsite_name"
                                  placeholder="EnhanceMyStay"/>
                    <x-input-error :messages="$errors->get('resdiary_microsite_name')" class="mt-2"/>
                </div>
                @endif
                <div class="text-right">
                    <x-primary-button dusk="update-hotel-details" class=" mt-4">Update
                    </x-primary-button>
                </div>
            </div>
        </form>
        <form class="border-t border-[#C4C4C4] mt-4 pt-4 flex items-end justify-between"
              enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
            @csrf
            <div class="flex items-end justify-start">
                <div class="mr-12">
                    <p class="open-sans text-2xl mb-6">Logo</p>
                    <img src="{{$hotel->logo}}" alt="hotel" class="h-[70px] rounded-3xl mr-2"/>
                </div>

                <div class="mt-4">
                    <x-input-label class="text-black font-sans sr-only" for="logo" :value="__('Logo')"/>
                    <input type="file" name="logo" id="logo" value="{{$hotel->logo}}">
                </div>
            </div>
            <div>
                <x-primary-button class=" mt-4">Update</x-primary-button>
            </div>
        </form>

        <form class="border-t border-[#C4C4C4] mt-4 pt-4 flex items-end justify-between"
              enctype="multipart/form-data" method="post" action="/admin/hotel/{{$hotel->id}}/update">
            @csrf
            <div class="flex items-end justify-start">
                <div class="mr-12">
                    <p class="open-sans text-2xl mb-6">Cover Image</p>
                    <img alt="current featured image" class="w-[140px] h-auto"
                         src="{{$hotel->featured_image}}">
                </div>
                <x-input-label class="text-black font-sans sr-only" for="featured_image"
                               :value="__('Featured Image')"/>
                <input type="file" name="featured_image" id="featured_image">
            </div>
            <div>
                <x-primary-button class="mt-4">Update</x-primary-button>
            </div>
        </form>

        <form class="border-t border-[#C4C4C4] mt-4 pt-4 " method="post"
              action="/admin/hotel/{{$hotel->id}}/update">

            @include('admin.hotel.partials.colour-scheme', ['hotel' => $hotel])
            <div class="text-right">
                <x-primary-button class=" mt-4">Update
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
