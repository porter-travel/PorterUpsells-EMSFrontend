
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('unavailabilityForm');
    const unavailableFrom = document.getElementById('unavailable_from');
    const unavailableTo = document.getElementById('unavailable_to');
    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    errorContainer.style.marginTop = '10px';
    if(!form)
        return;

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Clear previous errors
        errorContainer.textContent = '';

        // Get the values of the date inputs
        const startDate = new Date(unavailableFrom.value);
        const endDate = new Date(unavailableTo.value);

        // Check if start date is before end date
        if (startDate >= endDate) {
            errorContainer.textContent = 'The start date must be before the end date.';
            return;
        }

        // If validation passes, submit the form via AJAX
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Optional: to identify the request as AJAX
            },
        })
            .then(response => {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Failed to submit form');
                }
                return response.json(); // Assuming your backend returns JSON
            })
            .then(data => {
                // Handle successful form submission
                location.reload()
                // Optionally, close the modal or reset the form
                document.getElementById('unavailabilityModal').classList.add('hidden');
            })
            .catch(error => {
                // Handle any errors
                console.error('Error:', error);
                errorContainer.textContent = 'An error occurred while submitting the form. Please try again.';
            });
    });

    // Close modal functionality
    const closeModalButton = document.getElementById('closeUnavailabilityModal');
    closeModalButton.addEventListener('click', function () {
        document.getElementById('unavailabilityModal').classList.add('hidden');
    });

    const triggerUnavailabilityModal = document.getElementById('triggerUnavailabilityModal');
    triggerUnavailabilityModal.addEventListener('click', function () {
        document.getElementById('unavailabilityModal').classList.remove('hidden');
    });

});
