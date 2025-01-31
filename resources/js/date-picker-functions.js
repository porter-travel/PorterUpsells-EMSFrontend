document.addEventListener('DOMContentLoaded', function() {
    const startDatePicker = flatpickr("#startDatePicker", {
        dateFormat: 'Y-m-d',
        altFormat: 'J M, Y',
        altInput: true,
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                const startDate = selectedDates[0];

                // Set minDate for end date
                endDatePicker.set('minDate', startDate);
            }
        }
    });

    const endDatePicker = flatpickr("#endDatePicker", {
        dateFormat: 'Y-m-d',
        altFormat: 'J M, Y',
        altInput: true,
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                startDatePicker.set('maxDate', selectedDates[0]); // Set maxDate for start date
            }
        }
    });

    const arrivalPicker = flatpickr("#arrival-date", {
        dateFormat: 'Y-m-d',
        altFormat: 'J M, Y',
        altInput: true,
        minDate: 'today',
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                const arrivalDate = selectedDates[0];

                // Set minDate for departure
                departurePicker.set('minDate', arrivalDate);

                // If departure date is not set, default to one day after arrival
                if (!departurePicker.selectedDates.length) {
                    const nextDay = new Date(arrivalDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    departurePicker.setDate(nextDay, true); // true triggers onChange
                }
            }
        }
    });

    const departurePicker = flatpickr("#departure-date", {
        dateFormat: 'Y-m-d',
        altFormat: 'J M, Y',
        altInput: true,
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                arrivalPicker.set('maxDate', selectedDates[0]); // Set maxDate for arrival
            }
        }
    });


    const calendarDatePicker = flatpickr("#calendarDatePicker", {
        dateFormat: 'Y-m-d',
        altFormat: 'J M, Y',
        altInput: true,
    });



})
