<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar Orders for: ') . $product->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="get">
                        <div class="flex items-center pb-6">
                            <div class="mx-4">
                                <label>Date
                                    <input type="date" name="date" value="{{$date}}"></label>
                            </div>
                            <div>
                                <x-secondary-button type="submit">Filter</x-secondary-button>
                            </div>
                        </div>
                    </form>

                    <div class="flex h-[85vh] relative">

                        <div
                            class="h-[85vh] border border-darkGrey rounded-l-2xl overflow-hidden basis-1/12 bg-[#f7f7f7] px-1">
                            @foreach($availableTimes[0] as $key => $slot)
                                @if($key != 0)
                                    <div
                                        style="top: {{(100 / count($availableTimes[0])) * ($key)}}%; width: {{(count($availableTimes) * 16.66667)}}%; left: 8.33333%"
                                        class=" absolute  border-b border-darkGrey"></div>
                                @endif
                                <div class="relative w-full" style="height: {{100 / count($availableTimes[0])}}%">
                                    <p class="text-center pt-2 font-bold">{{$slot['time']}}</p>
                                </div>
                            @endforeach
                        </div>
                        @foreach($availableTimes as $key => $availability)
                            <div class="h-[85vh] w-1/6 basis-1/6">
                                <div
                                    class="h-full border border-darkGrey border-l-0 flex flex-col items-start justify-between @if($key == array_key_last($availableTimes)) rounded-r-2xl @endif">
                                    @foreach($availability as $slotKey => $slot)
                                        <div class="relative w-full cursor-pointer"
                                             style="height: {{100 / count($availableTimes[0])}}%">

                                            @if(!empty($slot['booking']))
                                                <div class="h-full p-1 mx-1">
                                                    <div class="mx-2 h-full bg-lightBlue rounded-lg p-2">
                                                        <p class="text-sm open-sans">{{$slot['booking']->name}}</p>
                                                        @if($slot['booking']->room)
                                                            <p>Room: {{$slot['booking']->room}}</p>
                                                        @endif
                                                        <p>{{substr($slot['booking']->start_time, 0, -3)}}
                                                            - {{substr($slot['booking']->end_time, 0, -3)}}</p>
                                                    </div>
                                                </div>
                                            @else

                                                <div data-time="{{$slot['time']}}"
                                                     data-slot="{{$key}}"
                                                     class="h-full p-1 mx-1 opacity-0 hover:opacity-50 newModalBookingTrigger">
                                                    <div class="mx-2 h-full bg-lightBlue rounded-lg p-2">
                                                        <svg class="w-full h-full object-contain" viewBox="0 0 512 512">
                                                            <path fill="#fff"
                                                                  d="M417.4,224H288V94.6c0-16.9-14.3-30.6-32-30.6c-17.7,0-32,13.7-32,30.6V224H94.6C77.7,224,64,238.3,64,256  c0,17.7,13.7,32,30.6,32H224v129.4c0,16.9,14.3,30.6,32,30.6c17.7,0,32-13.7,32-30.6V288h129.4c16.9,0,30.6-14.3,30.6-32  C448,238.3,434.3,224,417.4,224z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach


                                </div>
                            </div>

                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>


    <div id="newBookingModalContainer" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="bg-black opacity-50 absolute inset-0"></div>
        <div class="bg-white top-[50px] left-1/2 fixed transform -translate-x-1/2 w-1/2 p-4 rounded-lg shadow-lg">
            <div class="flex justify-between">
                <h2 class="text-xl font-bold mb-6">New Booking for {{$product->name}}</h2>
                <button class="closeNewBookingModal" class="text-xl font-bold">&times;</button>
            </div>
            <form method="post"
                  action="{{route('calendar.store-booking', ['hotel_id' => $hotel->id, 'product_id' => $product->id])}}">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="date" value="{{$date}}">
                <input type="hidden" name="slot" value="">

                <div class="flex justify-start">
                    <div class="basis-1/2">
                        <x-input-label for="start_time">Start Time</x-input-label>
                        <x-text-input disabled id="start_time_fake"/>
                        <input type="hidden" name="start_time" id="start_time"/>
                    </div>
                    <div class="basis-1/2">
                        <x-input-label for="end_time">End Time</x-input-label>
                        <select name="end_time" id="end_time" class="border-[#C4C4C4] focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col mb-2">
                    <x-input-label for="name">Name</x-input-label>
                    <x-text-input required type="text" name="name" id="name"/>
                </div>
                <div class="flex flex-col mb-2">
                    <x-input-label for="room">Room Number</x-input-label>
                    <x-text-input type="text" name="room" id="room"/>
                </div>
                <div class="flex flex-col mb-2">
                    <x-input-label for="email">Email</x-input-label>
                    <x-text-input type="email" name="email" id="email"/>
                </div>
                <div class="flex flex-col mb-2">
                    <x-input-label for="phone">Mobile Number</x-input-label>
                    <x-text-input type="tel" name="phone" id="phone"/>
                </div>
                <div class="flex justify-between">
                    <x-primary-button type="submit" class="bg-green-500 text-white rounded-lg p-2">Save
                    </x-primary-button>
                </div>
            </form>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bookingTriggers = document.querySelectorAll('.newModalBookingTrigger');
            const nameInput = document.getElementById('name');

            bookingTriggers.forEach(trigger => {
                trigger.addEventListener('click', async function () {
                    const newBookingModal = document.getElementById('newBookingModalContainer');
                    const startTime = this.getAttribute('data-time');
                    const slot = this.getAttribute('data-slot');
                    const startTimeInput = document.getElementById('start_time_fake');
                    const startTimeInputReal = document.getElementById('start_time');
                    const slotInput = document.querySelector('input[name="slot"]');
                    slotInput.value = slot;
                    startTimeInput.value = startTime;
                    startTimeInputReal.value = startTime;

                    axios.post('/admin/calendar/{{$product->id}}/get-future-availability-on-same-day', {
                        date: '{{$date}}',
                        hotel_id: '{{$hotel->id}}',
                        slot: slot,
                        start_time: startTime
                    }).then(response => {
                        const endTimeInput = document.getElementById('end_time');
                        //Create an option for each available time
                        console.log(endTimeInput);
                        endTimeInput.innerHTML = '';
                        response.data.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time;
                            option.innerText = time;
                            endTimeInput.appendChild(option);
                        });
                    });

                    // Show the modal
                    newBookingModal.classList.remove('hidden');
                });
            });

            const closeButtons = document.querySelectorAll('.closeNewBookingModal');
            closeButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const newBookingModal = document.getElementById('newBookingModalContainer');
                    newBookingModal.classList.add('hidden');
                });
            });


        });
    </script>
</x-hotel-admin-layout>
