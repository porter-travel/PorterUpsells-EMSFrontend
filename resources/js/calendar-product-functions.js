document.addEventListener("DOMContentLoaded", function () {

    function fetchAvailability() {
        document.getElementById('calendar_product_time_selector').innerHTML = '<p>Loading...</p>';
        const stayDateInput = document.querySelector("[data-stay-date-selector]:checked"); // Only get selected/checked input
        if (stayDateInput) {
            const date = stayDateInput.value;

            const product_id = document.querySelector("[data-product-id]").value;
            const day_of_the_week = stayDateInput.dataset.dayOfTheWeek

            console.log("Date:", date);
            console.log("Product ID:", product_id);
            console.log("Day of the week:", day_of_the_week);


            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Set the CSRF token as a header in axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

            // Make the axios request with the stay date value
            axios.post('/get-times-available-for-calendar-products', {
                date: date,
                product_id: product_id,
                day: day_of_the_week
            })
                .then(response => {
                    console.log("Response:", response.data);
                    processAvailableTimes(response.data);
                    getQtyFromSelectedTime()
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        } else {
            console.error("No date selected.");
        }
    }

    // Initial fetch on page load
    const formComponent = document.querySelector("[data-calendar]");
    if (formComponent) {
        fetchAvailability(); // Run on load

        // Add event listener to all stay date inputs
        const stayDateInputs = document.querySelectorAll("[data-stay-date-selector]");
        stayDateInputs.forEach(input => {
            input.addEventListener('change', fetchAvailability); // Run on input change
        });
    } else {
        console.log("Form does not require ResDiary booking.");
    }

    function processAvailableTimes(times) {
console.log("Times:", times);
        let output
        if(times.length === 0) {
            setMaxQty(0)
            output = '<p>Unfortunately there are no times available for this day, please try a different day</p>';
            document.getElementById('addToCartButton').disabled = true;
        } else {
            document.getElementById('addToCartButton').disabled = false;

            setMaxQty(times[0].qty);
            output  = '<label for="arrival_time">From Time</label>';
            output += '<select id="calendarProductSelector" class="w-full rounded mr-2" name="arrival_time">';
            times.forEach(time => {
                output += `<option data-availability="${time.qty}">${time.time}</option>`;
            })
            output += '</select>';
        }
        document.getElementById('calendar_product_time_selector').innerHTML = output;
    }

    function getQtyFromSelectedTime() {
        const selectElement = document.getElementById('calendarProductSelector');

        selectElement.addEventListener('change', function () {
            // Get the selected option
            const selectedOption = this.options[this.selectedIndex];

            // Access the data attribute
            const maxQty = selectedOption.getAttribute('data-availability');

            setMaxQty(maxQty);
        });
    }

    function setMaxQty(qty) {
        const numberInput = document.getElementById('quantity');
        const maxQtyInput = document.getElementById('maxQtyInput');
        numberInput.setAttribute('max', qty);
        maxQtyInput.value = qty;
    }
})




