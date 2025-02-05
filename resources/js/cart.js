import axios from "axios";


function serialize(data) {
    let obj = {};
    for (let [key, value] of data) {
        if (obj[key] !== undefined) {
            if (!Array.isArray(obj[key])) {
                obj[key] = [obj[key]];
            }
            obj[key].push(value);
        } else {
            obj[key] = value;
        }
    }
    return obj;
}

const form = document.getElementById('addToCart');

if (form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let data = new FormData(form);

        let formObj = serialize(data);

        console.log(formObj);

        axios.post('/cart/add', {formObj})
            .then(function (response) {
                console.log(response.data);
                if(response.data.error) {
                    alert(response.data.message);
                }
                else {
                    document.getElementById('cartCount').innerText = response.data.cart.cartCount;
                    document.getElementById('success').classList.remove('hidden');
                    document.getElementById('success').classList.add('block')
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });
}

const removeFromCart = document.getElementsByClassName('remove-from-cart');
// Iterate over the elements and add event listener

if (removeFromCart) {
    Array.from(removeFromCart).forEach(element => {
        element.addEventListener('click', function (event) {
            // Prevent the default action of the link
            event.preventDefault();

            // Extract the href attribute
            const url = this.getAttribute('href');
            const key = this.getAttribute('data-key');

            // Make a POST request using Axios
            axios.post(url)
                .then(response => {
                    // Handle successful response if needed
                    console.log('Post request successful');
                    document.getElementById('cartItem' + key).remove();
                    updateTotals(response.data[0]);
                })
                .catch(error => {
                    // Handle error if needed
                    console.error('Error making POST request:', error);
                });
        });
    });
}

const cartProductQuantity = document.getElementsByClassName('cart-product-quantity');

if (cartProductQuantity) {
    Array.from(cartProductQuantity).forEach(element => {
        element.addEventListener('change', function (event) {
            // Prevent the default action of the link
            event.preventDefault();

            // Extract the href attribute
            const url = '/cart/update/' + this.getAttribute('name');
            setTimeout(() => {
                // Make a POST request using Axios
                axios.post(url, {quantity: this.value})
                    .then(response => {
                        // Handle successful response if needed
                        console.log(response);
                        updateTotals(response.data[0]);
                    })
                    .catch(error => {
                        // Handle error if needed
                        console.error('Error making POST request:', error);
                    });
            }, 100);
        });
    });
}

function updateTotals(data) {
    const subtotal = document.getElementById('cartSubtotal');
    const tax = document.getElementById('cartTax');
    const total = document.getElementById('cartTotal');

    if (subtotal) {
        subtotal.innerText = '£' + data.total.toFixed(2);
    }
    if (tax) {
        tax.innerText = '£' + data.tax.toFixed(2);
    }
    if (total) {
        total.innerText = '£' + data.total.toFixed(2);
    }

    for (let key in data) {
        if (typeof data[key] === 'object') {
            const price = data[key].price;
            const quantity = data[key].quantity;
            const subtotal = price * quantity;
            document.getElementById('cartItem' + key).querySelector('.cart-product-subtotal').innerText = '£' + subtotal.toFixed(2);
        }
    }
}

// Get the expiry time from the data attribute
const countdownElement = document.getElementById('cartCountdown');
if(countdownElement) {
    const targetTimestamp = parseInt(countdownElement.dataset.expiry); // Assuming it's in Unix timestamp format (seconds)

// Check if the timestamp is valid
    if (!isNaN(targetTimestamp)) {
        // Convert Unix timestamp to milliseconds
        const targetTime = targetTimestamp * 1000;

        function updateCountdown() {
            const currentTime = new Date().getTime(); // Current time in milliseconds
            const timeLeft = targetTime - currentTime; // Time remaining in milliseconds

            if (timeLeft <= 0) {
                clearInterval(interval); // Stop the countdown
                countdownElement.textContent = "Expired";
                return;
            }

            // Calculate days, hours, minutes, and seconds
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            // Display the countdown in the span
            countdownElement.textContent = `${minutes}m ${seconds}s`;
        }

        // Update every second
        const interval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call to display immediately
    } else {
        countdownElement.textContent = "Invalid expiry time";
    }


}
