@if(!isset($product))
    @php
        $product = new \App\Models\Product();
    @endphp
@endif


@php
    $on_arrival_checked = '';
    if(isset($product->specifics['on_arrival'])){
      if($product->specifics['on_arrival']){
         $on_arrival_checked = 'checked';
      }
    }else{
        $on_arrival_checked = 'checked';
    }
@endphp


<div class="flex items-start justify-start flex-wrap">
    <div class="mt-4 basis-1/2 pr-4">
        <hr>

        <h4 class="font-bold py-4">Availability</h4>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[on_arrival]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[on_arrival]" value="1"
                   id="on_arrival" {{$on_arrival_checked }}>
            <x-input-label class="text-black font-sans" for="on_arrival"
                           :value="__('Available on date of arrival')"/>

        </div>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[during_stay]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[during_stay]" value="1" id="during_stay"
                @checked($product->specifics['during_stay'])>
            <x-input-label class="text-black font-sans" for="during_stay"
                           :value="__('Available during stay')"/>

        </div>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[on_departure]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[on_departure]" value="1" id="on_departure"
                @checked($product->specifics['on_departure'])>

            <x-input-label class="text-black font-sans" for="on_departure"
                           :value="__('Available on date of departure')"/>
        </div>
    </div>

    <div class="mt-4 basis-1/2 pl-4">
        <hr>

        <h4 class="font-bold py-4">Storage / Quality</h4>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[after_checkin]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[after_checkin]" value="1" id="after_checkin"
                @checked($product->specifics['after_checkin'])>

            <x-input-label class="text-black font-sans" for="after_checkin"
                           :value="__('Product can only be delivered after guest has checked in')"/>
        </div>
    </div>

    <div class="mt-4 basis-1/2 pr-4">
        <hr>

        <h4 class="font-bold py-4">Notice Period</h4>
        <div class="flex items-center justify-start">
            <x-input-label class="text-black font-sans" for="after_checkin">
                Product must be ordered at least
                <input min="0" style="width: 70px; text-align: center" type="number" name="specifics[notice_period]"
                       value="{{(isset($product->specifics['notice_period']) && $product->specifics['notice_period']) ? $product->specifics['notice_period'] : 0}}"
                       id="notice_period">
                day(s) before arrival
            </x-input-label>
        </div>
    </div>

    <div class="mt-4 basis-1/2 pl-4">
    </div>
    <div class="mt-4 basis-1/2 pr-4">
        <hr>
        <h4 class="font-bold py-4">Available Days</h4>
        <ul class="flex flex-wrap">
            @php
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            @endphp
            @foreach($days as $day)
                <li class="basis-full sm:basis-1/2 md:basis-1/3 ">
                    <label
                        class="border border-black bg-[#F7F7F7] rounded p-2 flex items-center mr-2 mb-2 basis-1/3 fancy-checkbox">
                        <input type="hidden" name="specifics[available_{{$day}}]" value="0">
                        <input
                            style="width: 0; height: 0; opacity: 0"
                            type="checkbox"
                            name="specifics[available_{{$day}}]" value="1"
                            id="{{$day}}" @checked($product->specifics['available_' . $day])
                        >
                        <span class="w-[29px] h-[29px] border border-darkGrey rounded mr-2 relative"></span>
                        <span></span>
                        <span class="relative">
                        <span class="font-bold">{{ucfirst($day)}}</span>
                    </span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4 basis-1/2 pl-4">
        <hr>
        <div class="flex items-center justify-between">
            <h4 class="font-bold py-4">Periods of Unavailability</h4>
            @if($method == 'update')
                <a id="triggerUnavailabilityModal" href="#">Add New</a>
            @endif
        </div>

        @if($method == 'create')
            <p>Once you have saved the product you will be able to set periods of unavailability</p>
        @else
            <ul>
                @foreach($product->unavailabilities as $unavailability)
                    <li class="border-b pb-2 mb-2 flex items-center justify-between">
                        @if($unavailability->is_recurrent)
                            <span>
                            {{\App\Helpers\Date::formatToDayAndMonth($unavailability->start_at)}}
                            - {{\App\Helpers\Date::formatToDayAndMonth($unavailability->end_at)}} Every Year
                                </span>
                        @else
                            <span>
                            {{\App\Helpers\Date::formatToDayMonthYear($unavailability->start_at)}}
                            - {{\App\Helpers\Date::formatToDayMonthYear($unavailability->end_at)}}
                            </span>
                        @endif

                        <a href="/admin/unavailability/{{$unavailability->id}}/delete"
                           class="text-red-500">Delete</a>

                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>

