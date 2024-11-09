document.addEventListener("DOMContentLoaded", function() {
    // Check if the form component has the "data-requires-resdiary-booking" attribute
    const formComponent = document.querySelector("[data-requires-resdiary-booking]");
    if (formComponent) {
        // Find the input element with the "data-stay-date-selector" attribute
        const stayDateInput = document.querySelector("[data-stay-date-selector]");

        if (stayDateInput) {
            const date = stayDateInput.value;

            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Set the CSRF token as a header in axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

            // Make the axios request with the stay date value
            axios.post('/resdiary/get-availability', {
                date: date
            })
                .then(response => {
                    console.log("Response:", response.data);
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        } else {
            console.error("Input with 'data-stay-date-selector' not found.");
        }
    } else {
        console.log("Form does not require ResDiary booking.");
    }
});
