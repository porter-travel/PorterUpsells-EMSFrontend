<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Calendar Orders for: ') . $product->name }}
            </h2>

            <div id="product-selector" class="border rounded flex justify-between relative">
                <span class="p-2">
                {{$product->name}}
                    </span>
                <ul class="w-full border rounded p-2 hidden absolute bg-white top-full">
                    @php
                        $queryString = request()->getQueryString();
                        $queryString = $queryString ? '?' . $queryString : '';
                    @endphp
                    @foreach($products as $loopProduct)
                        <li class="@if($product->id == $loopProduct->id) hidden @endif">
                            <a href="{{ route('calendar.list-bookings-for-product', ['hotel_id' => $hotel->id, 'product_id' => $loopProduct->id]) . $queryString }}">
                                {{$loopProduct->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <button class="bg-lightBlue rounded p-2 flex items-center">
                    <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 8L15 0H0L7.5 8Z" fill="black"/>
                    </svg>
                </button>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <form method="get">
                            <p class="font-bold pb-2">Date</p>
                            <div class="flex items-center justify-center pb-12">
                                <a href="?date={{$yesterday}}"><svg width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M-2.40413e-07 5.5L6 11L6 0L-2.40413e-07 5.5Z" fill="black"/>
                                    </svg>
                                </a>
                                <div class="mx-4">
                                    <label><span class=" sr-only block">Date</span>
                                        <input onchange="this.form.submit();" type="date" name="date" value="{{$date}}"></label>
                                </div>
                                <a href="?date={{$tomorrow}}"><svg width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 5.5L-4.80825e-07 0L0 11L6 5.5Z" fill="black"/>
                                    </svg>
                                </a>
                            </div>
                        </form>

                        <div>


                        </div>


                    </div>
                    <div class="flex h-[85vh] relative">

                        @if($availableTimes)
                            <div style="width: {{(count($availableTimes) * 16.66667)}}%" class="absolute  px-2 py-1 top-0 -translate-y-full bg-grey rounded-tl-2xl border-l border-r border-t border-darkGrey">
                                Times
                            </div>
                        <div
                            class="h-[85vh] border border-darkGrey rounded-bl-2xl overflow-hidden basis-1/12 bg-[#f7f7f7] px-1">
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

                            <div class="h-[85vh] w-1/6 basis-1/6 relative">
                                <div @if($key == array_key_first($availableTimes)) style="box-shadow: -1px 0 0 #000;" @endif class="absolute px-2 py-1 top-0 -translate-y-full  bg-grey w-full  border-r border-t border-darkGrey  @if($key == array_key_last($availableTimes)) rounded-tr-2xl @else  @endif">
                                    Slot {{$key + 1}}
                                </div>
                                <div
                                    class="h-full border border-darkGrey border-l-0 flex flex-col items-start justify-between @if($key == array_key_last($availableTimes)) rounded-br-2xl @endif">
                                    @foreach($availability as $slotKey => $slot)
                                        @if($slot['booking'] && $slot['booking']['parent_booking_id'])
                                            @continue
                                        @endif
                                        <div class="relative w-full cursor-pointer "
                                             style="height: {{(100 / count($availableTimes[0])) * ($slot['booking'] ? $slot['booking']['bookings_count'] : 1)}}%">

                                            @if(!empty($slot['booking']))
                                                <div
                                                    data-time="{{$slot['time']}}"
                                                    data-slot="{{$key}}"
                                                    data-end-time="{{$slot['booking']['end_time']}}"
                                                    data-booking-id="{{$slot['booking']['id']}}"
                                                    data-name="{{$slot['booking']['name']}}"
                                                    data-room="{{$slot['booking']['room_number']}}"
                                                    data-email="{{$slot['booking']['email']}}"
                                                    data-phone="{{$slot['booking']['mobile']}}"
                                                    class="h-full p-1 mx-1 modifyModalBookingTrigger">
                                                    @if($slot['booking']['name'] == '__block__')

                                                        <div class="mx-2 h-full bg-pink rounded-lg p-2 overflow-hidden">
                                                            <p class="text-sm open-sans">BLOCK</p>
                                                            <p>{{substr($slot['booking']['start_time'], 0, -3)}}
                                                                - {{substr($slot['booking']['end_time'], 0, -3)}}</p>
                                                        </div>
                                                    @else

                                                        <div class="mx-2 h-full bg-lightBlue rounded-lg p-2 overflow-hidden">
                                                            <p class="text-sm open-sans">{{$slot['booking']['name']}}</p>
                                                            @if($slot['booking']['room_number'])
                                                                <p class="text-xs">
                                                                    Room: {{$slot['booking']['room_number']}}</p>
                                                            @endif
                                                            <p>{{substr($slot['booking']['start_time'], 0, -3)}}
                                                                - {{substr($slot['booking']['end_time'], 0, -3)}}</p>
                                                        </div>
                                                    @endif
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
@else
    <div class="w-full text-center">
        <p>No bookings available for this product on this date</p>
    </div>
                            @endif
                    </div>


                </div>
            </div>
        </div>
    </div>


    <div id="newBookingModalContainer" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="bg-black opacity-50 absolute inset-0"></div>
        <div class="bg-white top-[50px] left-1/2 fixed transform -translate-x-1/2 w-1/2 p-4 rounded-lg shadow-lg overflow-auto max-h-[80vh]">
            <div class="flex justify-between">
                <h2 class="text-xl font-bold mb-6"><span id="modal_title_verb">New</span> Booking for {{$product->name}}
                </h2>
                <button class=" closeNewBookingModal text-xl font-bold">&times;</button>
            </div>
            <form method="post"
                  id="calendar-booking-form"
                  data-store-action="{{route('calendar.store-booking', ['hotel_id' => $hotel->id, 'product_id' => $product->id])}}"
                  data-update-action="{{route('calendar.update-booking')}}"
            >
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="date" value="{{$date}}">
                <input type="hidden" name="slot" value="">
                <input type="hidden" name="booking_id" value="">

                <div class="flex justify-start mb-2">
                    <div class="basis-1/2">
                        <x-input-label for="start_time">Start Time</x-input-label>
                        <x-text-input disabled id="start_time_fake"/>
                        <input type="hidden" name="start_time" id="start_time"/>
                    </div>
                    <div class="basis-1/2">
                        <x-input-label for="end_time">End Time</x-input-label>
                        <select name="end_time" id="end_time"
                                class="border-[#C4C4C4] focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="">Select</option>
                        </select>
                        <x-text-input disabled id="end_time_fake"/>
                    </div>
                </div>
                <div class="flex flex-col mb-2">
                    <x-fancy-checkbox id="make_unavailable" name="make_unavailable"
                                      label="Mark as Unavailable"></x-fancy-checkbox>
                </div>
                <div id="form-fields">
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
                </div>
                <div id="confirmation-message" class="hidden mb-2 text-red-600 font-bold">
                    Confirming this booking will prevent other people from booking this slot at this time.
                </div>
                <div class="flex justify-between">
                    <x-primary-button id="store-button" type="submit" class="bg-green-500 text-white rounded-lg p-2">
                        Save
                    </x-primary-button>
                    <x-danger-button type="button" id="deleteBooking" class="hidden ">Delete</x-danger-button>
                </div>
            </form>
            <form method="post" id="deleteForm" class="hidden" action="{{route('calendar.delete-booking')}}">
                @csrf
                <div class="bg-pink my-4 rounded p-4">
                    <h3 class="text-xl">Are you sure you would like to delete this booking?</h3>
                    <p>This action cannot be undone and will cause the booking to be permanently deleted</p>
                    <input type="hidden" name="booking_id" value="">
                    <x-danger-button type="submit">Delete Permanently</x-danger-button>
                </div>

            </form>

        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkbox = document.querySelector('#make_unavailable');
            const formFields = document.querySelector('#form-fields');
            const confirmationMessage = document.querySelector('#confirmation-message');
            const nameField = document.querySelector('#name');

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    // Hide the form fields and show the confirmation message
                    formFields.classList.add('hidden');
                    confirmationMessage.classList.remove('hidden');

                    // Set the name field to "__block__"
                    nameField.value = '__block__';
                } else {
                    // Show the form fields and hide the confirmation message
                    formFields.classList.remove('hidden');
                    confirmationMessage.classList.add('hidden');

                    // Clear the name field value
                    nameField.value = '';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bookingTriggers = document.querySelectorAll('.newModalBookingTrigger');
            const modal_title_verb = document.getElementById('modal_title_verb');
            const form = document.getElementById('calendar-booking-form');
            const storeButton = document.getElementById('store-button');
            const deleteButton = document.getElementById('deleteBooking');
            const deleteForm = document.getElementById('deleteForm');
            bookingTriggers.forEach(trigger => {
                trigger.addEventListener('click', async function () {
                    modal_title_verb.innerText = 'New';
                    const newBookingModal = document.getElementById('newBookingModalContainer');
                    const startTime = this.getAttribute('data-time');
                    const endTime = this.getAttribute('data-end-time');
                    const slot = this.getAttribute('data-slot');
                    const startTimeInput = document.getElementById('start_time_fake');
                    const startTimeInputReal = document.getElementById('start_time');
                    const slotInput = document.querySelector('input[name="slot"]');
                    slotInput.value = slot;
                    startTimeInput.value = startTime;
                    startTimeInputReal.value = startTime;

                    const endTimeInput = document.getElementById('end_time');
                    endTimeInput.classList.remove('hidden');
                    const endTimeInputFake = document.getElementById('end_time_fake');
                    endTimeInputFake.classList.add('hidden');

                    axios.post('/admin/calendar/{{$product->id}}/get-future-availability-on-same-day', {
                        date: '{{$date}}',
                        hotel_id: '{{$hotel->id}}',
                        slot: slot,
                        start_time: startTime,
                        end_time: endTime
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

                    //Set the action of the form to the store action

                    form.action = form.getAttribute('data-store-action');
                    storeButton.innerText = 'Save';
                    deleteButton.classList.add('hidden');
                    deleteForm.classList.add('hidden');

                    // Show the modal
                    newBookingModal.classList.remove('hidden');
                });
            });

            const modifyBookingTriggers = document.querySelectorAll('.modifyModalBookingTrigger');

            modifyBookingTriggers.forEach(trigger => {
                trigger.addEventListener('click', async function () {
                    modal_title_verb.innerText = 'Modify';
                    const newBookingModal = document.getElementById('newBookingModalContainer');
                    const startTime = this.getAttribute('data-time');
                    const endTime = this.getAttribute('data-end-time');
                    const slot = this.getAttribute('data-slot');
                    const startTimeInput = document.getElementById('start_time_fake');
                    const startTimeInputReal = document.getElementById('start_time');
                    const slotInput = document.querySelector('input[name="slot"]');
                    const booking_id = this.getAttribute('data-booking-id');
                    const bookingIdInput = document.querySelectorAll('input[name="booking_id"]');
                    const name = this.getAttribute('data-name');
                    const room = this.getAttribute('data-room');
                    const email = this.getAttribute('data-email');
                    const phone = this.getAttribute('data-phone');

                    deleteButton.classList.remove('hidden');

                    axios.post('/admin/calendar/{{$product->id}}/get-future-availability-on-same-day', {
                        date: '{{$date}}',
                        hotel_id: '{{$hotel->id}}',
                        slot: slot,
                        start_time: startTime,
                        end_time: endTime,
                        booking_id: booking_id
                    }).then(response => {
                        const endTimeInput = document.getElementById('end_time');
                        //Create an option for each available time
                        console.log(endTimeInput);
                        console.log(response.data)
                        endTimeInput.innerHTML = '';
                        response.data.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time;
                            option.innerText = time;
                            endTimeInput.appendChild(option);
                        });
                        endTimeInput.value = endTime;
                    });

                    const nameInput = document.getElementById('name');
                    nameInput.value = name;

                    if (name === '__block__') {
                        const checkbox = document.querySelector('#make_unavailable');
                        checkbox.checked = true;
                        const formFields = document.querySelector('#form-fields');
                        const confirmationMessage = document.querySelector('#confirmation-message');
                        formFields.classList.add('hidden');
                        confirmationMessage.classList.remove('hidden');
                    }

                    const roomInput = document.getElementById('room');
                    roomInput.value = room;
                    const emailInput = document.getElementById('email');
                    emailInput.value = email;
                    const phoneInput = document.getElementById('phone');
                    phoneInput.value = phone;

                    bookingIdInput.forEach(input => {
                        input.value = booking_id;
                    })
                    slotInput.value = slot;
                    startTimeInput.value = startTime;
                    startTimeInputReal.value = startTime;

                    // const endTimeInput = document.getElementById('end_time');
                    // endTimeInput.classList.add('hidden');
                    const endTimeInputFake = document.getElementById('end_time_fake');
                    endTimeInputFake.classList.add('hidden');
                    // endTimeInputFake.value = endTime;

                    //set the action of the form to the update action
                    form.action = form.getAttribute('data-update-action');
                    storeButton.innerText = 'Update';


                    // Show the modal
                    newBookingModal.classList.remove('hidden');
                });
            });

            deleteButton.addEventListener('click', function () {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.classList.remove('hidden');
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

        const productSelector = document.getElementById('product-selector');
        const productSelectorList = productSelector.querySelector('ul');
        const productSelectorButton = productSelector.querySelector('button');

        productSelectorButton.addEventListener('click', () => {
            productSelectorList.classList.toggle('hidden');
        });

    </script>
</x-hotel-admin-layout>
