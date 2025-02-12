document.addEventListener('DOMContentLoaded', function () {
    const options = document.getElementById('options');
    if(options){
        options.addEventListener('change', function (event) {
            console.log(event.target.value);
            const id = event.target.value;
            productVariations.map((variation) => {
                if (variation.id == id) {
                    const priceEl = document.getElementById('price');
                    const currency = priceEl.getAttribute('data-currency');
                    let price = variation.price * 1;
                    document.getElementById('price').innerHTML = `${price.toLocaleString('en-GB', {'style': 'currency', 'currency': currency})}`;
                    document.getElementById('productImage').src = variation.image;
                }
            })
        })
    }

})
