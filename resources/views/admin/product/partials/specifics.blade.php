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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Select all the list items with the class 'settings-button'
        const buttons = document.querySelectorAll('.settings-button');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                // Get the target ID from the clicked button's data-target attribute
                const targetId = button.getAttribute('data-target');

                // Hide all elements with the class 'settings-tab'
                document.querySelectorAll('.settings-tab').forEach(tab => {
                    tab.style.display = 'none';
                });

                // Show the element with the matching ID
                const targetTab = document.getElementById(targetId);
                if (targetTab) {
                    targetTab.style.display = 'block';
                }

                // Remove the 'active' class from all buttons
                buttons.forEach(btn => btn.classList.remove('active'));

                // Add the 'active' class to the clicked button
                button.classList.add('active');
            });
        });
    });

</script>

<style>
    .settings-button.active {
        background: #DFF9DD;
    }
</style>

<div class="flex items-start mt-8 border-grey border rounded-2xl p-6 bg-[#fafafa]">
    <div class="lg:basis-1/5 pr-4">
        <ul>
            <li data-target="availability-tab"
                class="settings-button text-lg mb-2 px-4 py-2 bg-grey rounded-full cursor-pointer active">Availability
            </li>
            <li data-target="storage-tab"
                class="settings-button text-lg mb-2 px-4 py-2 bg-grey rounded-full cursor-pointer">Storage / Quality
            </li>
            <li data-target="notice-tab"
                class="settings-button text-lg mb-2 px-4 py-2 bg-grey rounded-full cursor-pointer">Notice Period
            </li>
            @foreach($hotel->connections as $connection)
                @if($connection->key == 'resdiary_microsite_name')
                    <li data-target="resdiary-tab"
                        class="settings-button text-lg mb-2 px-4 py-2 bg-grey rounded-full cursor-pointer">Resdiary
                    </li>
                @endif
            @endforeach
            @if($method == 'update')
                <li data-target="unavailability-tab"
                    class="settings-button text-lg mb-2 px-4 py-2 bg-grey rounded-full cursor-pointer">Unavailability
                </li>
            @endif
        </ul>
    </div>

    <div class="lg:basis-4/5">
        <div class="settings-tab" id="availability-tab">
            <div class="flex">
                <div class="lg:basis-1/2 basis-full">
                    <h4 class="font-bold pb-4">Availability</h4>
                    <div class="flex items-center justify-start">
                        <input type="hidden" name="specifics[on_arrival]" value="0">

                        <x-fancy-checkbox
                            label="Available on date of arrival"
                            name="specifics[on_arrival]"
                            :isChecked="isset($product->specifics['on_arrival']) ? $product->specifics['on_arrival'] : true"
                        />

                    </div>
                    <div class="flex items-center justify-start">
                        <input type="hidden" name="specifics[during_stay]" value="0">

                        <x-fancy-checkbox
                            label="Available during stay"
                            name="specifics[during_stay]"
                            :isChecked="isset($product->specifics['during_stay']) ? $product->specifics['during_stay'] : false"
                        />


                    </div>
                    <div class="flex items-center justify-start">
                        <input type="hidden" name="specifics[on_departure]" value="0">

                        <x-fancy-checkbox
                            label="Available on date of departure"
                            name="specifics[on_departure]"
                            :isChecked="isset($product->specifics['on_departure']) ? $product->specifics['on_departure'] : false"
                        />

                    </div>
                </div>
                <div class="lg:basis-1/2 basis-full">
                    <h4 class="font-bold pb-4">Available Days</h4>
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
            </div>
        </div>
        <div class="settings-tab hidden" id="storage-tab">
            <h4 class="font-bold pb-4">Storage / Quality</h4>
            <div class="flex items-center justify-start">
                <input type="hidden" name="specifics[after_checkin]" value="0">
                <x-fancy-checkbox
                    label="Product can only be delivered after guest has checked in"
                    name="specifics[after_checkin]"
                    :isChecked="isset($product->specifics['after_checkin']) ? $product->specifics['after_checkin'] : false"
                />
            </div>
        </div>
        <div class="hidden settings-tab" id="notice-tab">
            <h4 class="font-bold pb-4">Notice Period</h4>
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
        @foreach($hotel->connections as $connection)

            @if($connection->key == 'resdiary_microsite_name')
                <div class="hidden settings-tab" id="resdiary-tab">

                    <h4 class="font-bold pb-4">Resdiary</h4>
                    <div class="flex items-center justify-start flex-wrap">
                        <div class="flex items-center justify-start basis-full">

                            <input type="hidden" name="specifics[requires_resdiary_booking]" value="0">

                            <x-fancy-checkbox
                                label="Require ResDiary Booking"
                                name="specifics[requires_resdiary_booking]"
                                :isChecked="isset($product->specifics['requires_resdiary_booking']) ? $product->specifics['requires_resdiary_booking'] : false"
                            />
                        </div>
                        <div class="">
                            <x-input-label class="text-black font-sans" for="resdiary_promotion_id">
                                ResDiary Promotion ID
                            </x-input-label>
                            <x-text-input type="text" name="specifics[resdiary_promotion_id]"
                                          value="{{(isset($product->specifics['resdiary_promotion_id']) && $product->specifics['resdiary_promotion_id']) ? $product->specifics['resdiary_promotion_id'] : null}}"
                                          id="resdiary_promotion_id"/>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if($method == 'update')
            <div class="hidden settings-tab" id="unavailability-tab">

                <div class="flex items-center justify-between">
                    <h4 class="font-bold py-b">Periods of Unavailability</h4>

                    <a class="flex items-center px-8 py-2 bg-mint rounded-full" id="triggerUnavailabilityModal" href="#">
                        <img src="/img/icons/plus.svg" alt="add" class="mr-2">
                        Add New</a>
                </div>

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

            </div>
        @endif
    </div>
</div>

