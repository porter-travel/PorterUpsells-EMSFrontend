document.addEventListener('DOMContentLoaded', (event) => {
    const arrivalDateInput = document.getElementById('arrival-date');
    const departureDateInput = document.getElementById('departure-date');
    if(!arrivalDateInput || !departureDateInput) return;
    function validateDates() {
        const arrivalDate = new Date(arrivalDateInput.value);
        const departureDate = new Date(departureDateInput.value);

        if (arrivalDate >= departureDate) {
            // If arrival date is not before departure date, adjust the departure date
            departureDateInput.setCustomValidity('Departure date must be after arrival date.');
            departureDateInput.reportValidity();
        } else {
            departureDateInput.setCustomValidity('');
        }
    }

    arrivalDateInput.addEventListener('blur', () => {
        if (departureDateInput.value) {
            validateDates();
        }
    });

    departureDateInput.addEventListener('blur', () => {
        if (arrivalDateInput.value) {
            validateDates();
        }
    });
});
