@if($type == 'standard' || $type == 'restauarant')

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
                            id="{{$day}}"
                            @if($method == 'create')
                                checked
                        @else
                            @checked($product->specifics['available_' . $day])
                            @endif
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
@elseif($type == 'calendar')

    <div class="basis-full">

        <div class="flex mb-4">
            <div class="basis-1/2 pr-4">
                <x-input-label class="text-black font-sans" for="specifics[concurrent_availability]">
                    No. of spaces/items available concurrently:
                </x-input-label>
                <x-text-input
                    required
                    class="w-full"
                    type="number"
                    name="specifics[concurrent_availability]"
                    value="{{isset($product->specifics['concurrent_availability']) ?? 1}}"
                    placeholder="1"></x-text-input>
            </div>

            <div class="basis-1/2 pl-4">
                <x-input-label class="text-black font-sans" for="specifics[time_intervals]">
                    Time intervals of bookings:
                </x-input-label>
                <select
                    class="w-full"
                    type="number"
                    name="specifics[time_intervals]"
                    required
                    >
                    <option value="" disabled selected>Please Select</option>
                    <option @selected(isset($product->specifics['time_intervals']) && $product->specifics['time_intervals'] == '30mins') value="30mins">30 Minutes</option>
                    <option @selected(isset($product->specifics['time_intervals']) && $product->specifics['time_intervals'] == '1hr') value="1hr">1 Hour</option>
                    <option @selected(isset($product->specifics['time_intervals']) && $product->specifics['time_intervals'] == '2hrs') value="2hrs">2 Hours</option>
                    <option @selected(isset($product->specifics['time_intervals']) && $product->specifics['time_intervals'] == 'halfday') value="halfday">Half Day</option>
                    <option @selected(isset($product->specifics['time_intervals']) && $product->specifics['time_intervals'] == 'fullday') value="fullday">Full Day</option>

                </select>
            </div>
        </div>
        <div class="flex">
            <div class="basis-1/3">
                <h4 class="font-bold pb-4">Available Days</h4>
            </div>

            <div class="basis-1/3">
                <h4 class="font-bold pb-4">Start Time</h4>
            </div>

            <div class="basis-1/3">
                <h4 class="font-bold pb-4">End Time</h4>
            </div>
        </div>
        <ul class="">
            @php
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            @endphp
            @foreach($days as $day)
                <li class="flex">
                    <div class="basis-1/3">
                        <label
                            class="border border-black bg-[#F7F7F7] rounded p-2 flex items-center mr-2 mb-2 basis-1/3 fancy-checkbox">
                            <input type="hidden" name="specifics[available_{{$day}}]" value="0">
                            <input
                                style="width: 0; height: 0; opacity: 0"
                                type="checkbox"
                                name="specifics[available_{{$day}}]"
                                value="1"
                                id="available_{{$day}}"
                                @checked($product->specifics['available_' . $day])
                            >
                            <span class="w-[29px] h-[29px] border border-darkGrey rounded mr-2 relative"></span>
                            <span></span>
                            <span class="relative">
                <span class="font-bold">{{ ucfirst($day) }}</span>
            </span>
                        </label>
                    </div>

                    <div class="basis-1/3 pr-2">
                        <x-text-input
                            class="w-full"
                            type="time"
                            name="specifics[start_time_{{$day}}]"
                            id="start_time_{{$day}}"
                            :value="isset($product->specifics['start_time_' . $day]) ? $product->specifics['start_time_' . $day] : null"
                            placeholder="00:00"
                        />
                    </div>
                    <div class="basis-1/3">
                        <x-text-input
                            class="w-full"
                            type="time"
                            name="specifics[end_time_{{$day}}]"
                            id="end_time_{{$day}}"
                            :value="isset($product->specifics['end_time_' . $day]) ? $product->specifics['end_time_' . $day] : null"
                            placeholder="00:00"
                        />
                    </div>
                </li>
            @endforeach



        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const days = @json($days);

            days.forEach(day => {
                const checkbox = document.getElementById(`available_${day}`);
                const startTime = document.getElementById(`start_time_${day}`);
                const endTime = document.getElementById(`end_time_${day}`);

                // Update required attributes based on checkbox state
                const updateRequired = () => {
                    const isChecked = checkbox.checked;
                    startTime.required = isChecked;
                    endTime.required = isChecked;
                };

                // Initialize on page load
                updateRequired();

                // Add event listener to checkbox
                checkbox.addEventListener('change', updateRequired);
            });
        });
    </script>
@endif
