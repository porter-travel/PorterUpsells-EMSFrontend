// Get all number input components
const numberInputs = document.querySelectorAll('.number-input');


// Function to trigger change event
function triggerChangeEvent(element) {
    // Create a new change event
    const event = new Event('change', { bubbles: true });
    // Dispatch the event on the element
    element.dispatchEvent(event);
}


// Loop through each number input component
numberInputs.forEach(input => {
    // Get the input field and plus/minus buttons
    const inputField = input.querySelector('input[type="number"]');
    const plusButton = input.querySelector('.number-input-plus');
    const minusButton = input.querySelector('.number-input-minus');

    // Add click event listener to the plus button
    plusButton.addEventListener('click', () => {
        if(parseInt(inputField.value) >= parseInt(inputField.max)) {
            return;
        }
        // Increment the value of the input field
        inputField.value = parseInt(inputField.value) + 1;
        triggerChangeEvent(inputField);

    });

    // Add click event listener to the minus button
    minusButton.addEventListener('click', () => {
        // Ensure the value doesn't go below the minimum value
        if (parseInt(inputField.value) > parseInt(inputField.min)) {
            // Decrement the value of the input field
            inputField.value = parseInt(inputField.value) - 1;
            triggerChangeEvent(inputField);

        }
    });

    inputField.addEventListener('blur', () => {
        if (parseInt(inputField.value) > parseInt(inputField.max)) {
            inputField.value = parseInt(inputField.max);
        }
        if (parseInt(inputField.value) < parseInt(inputField.min)) {
            inputField.value = parseInt(inputField.min);
        }
        triggerChangeEvent(inputField);
    });
});
