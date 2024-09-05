<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bookings for: ') . $hotel->name }}
        </h2>
        <a href="{{route('booking.create', ['id' => $hotel->id])}}" class="text-black font-bold border rounded-xl p-4 hover:bg-mint">Create Booking</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="get">
                        @csrf
                        <div class="flex items-center pb-6">
                            <div>
                                <label>Start Date
                                    <input type="date" name="start_date" value="{{$startDate}}"></label>
                            </div>

                            <div class="mx-4">
                                <label>End Date
                                    <input type="date" name="end_date" value="{{$endDate}}"></label>
                            </div>
                            <div>
                                <x-secondary-button type="submit">Filter</x-secondary-button>
                            </div>
                        </div>
                    </form>

                    @if(count($bookings) > 0)

                        <div class="flex flex-wrap">
                            <table class="w-full rounded">
                                <thead>
                                <tr class="text-left bg-grey">
                                    <th class="p-2">Booking Ref</th>
                                    <th class="p-2">Details</th>
                                    <th class="p-2">Stay Dates</th>
                                    <th class="p-2">Room</th>
                                    <th class="p-2">Quick Link</th>
                                </tr>
                                </thead>
                                @foreach($bookings as $booking)

                                    {{--                                    {{dd($order->order_items)}}--}}

                                    <tr class="border">
                                        <td class="p-2">{{$booking->booking_ref}}</td>
                                        <td class="p-2">{{$booking->name}}<br>{{$booking->email_address}}</td>
                                        <td class="p-2"> {{\App\Helpers\Date::formatToDayAndMonth($booking->arrival_date)}} - {{\App\Helpers\Date::formatToDayAndMonth($booking->departure_date)}}</td>
                                        <td>
                                            <form class="update-form flex" method="post" action="/admin/booking/{{$booking->id}}/update">
                                                @csrf
                                                <input name="room" class="w-20" value="{{$booking->room}}">
                                                <button type="submit" class="update-room bg-grey border-r border-y rounded-tr rounded-br px-2">✓</button>
                                            </form>
                                        </td>
                                        <td>
                                        <input class=" w-0 p-0 opacity-0 booking-link" type="text" disabled
                                               value="{{env('APP_URL')}}/hotel/{{$hotel->slug}}/welcome?name={{$booking->name}}&arrival_date={{$booking->arrival_date}}&departure_date={{$booking->departure_date}}&email_address={{$booking->email_address}}&booking_ref={{$booking->booking_ref}}">
                                            <span class="copy-label cursor-pointer" onclick="copyToClipboard(this)">Copy</span>

                                        </td>


                                    </tr>

                                @endforeach
                            </table>

                        </div>

                    @else

                        <p>No orders to show</p>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(element) {
            const input = element.previousElementSibling;
            if (input && input.value) {
                // Create a temporary textarea element to hold the input value
                const tempTextArea = document.createElement('textarea');
                tempTextArea.value = input.value;
                document.body.appendChild(tempTextArea);
                tempTextArea.select();
                try {
                    document.execCommand('copy');
                    element.innerText = 'Copied';
                    setTimeout(() => {
                        element.innerText = 'Copy';
                    }, 2000);
                } catch (err) {
                    console.error('Unable to copy', err);
                }
                document.body.removeChild(tempTextArea);
            }
        }

        // Function to handle form submission without page reload
        document.addEventListener('DOMContentLoaded', function() {
            // Select all forms with the class 'update-form'
            const forms = document.querySelectorAll('.update-form');

            // Iterate through each form
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    // Get the form action URL and method
                    const url = form.action;
                    const method = form.method;

                    // Create a FormData object from the form
                    const formData = new FormData(form);

                    // Send the AJAX request using fetch
                    fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Optional: to specify AJAX request
                        }
                    })
                        .then(response => response.json()) // Assuming the response is in JSON format
                        .then(data => {
                            // Handle the response (e.g., update the page, display a message, etc.)
                            console.log('Success:', data);

                            // Find the submit button within the current form
                            const button = form.querySelector('.update-room');

                            // Change button background to green
                            button.style.backgroundColor = '#D4F6D1';

                            // Revert button background after 2 seconds
                            setTimeout(() => {
                                button.style.backgroundColor = ''; // Reset to original color
                            }, 2000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle errors (e.g., display an error message)
                        });
                });
            });
        });

    </script>
</x-app-layout>
