const container = document.getElementById('variantContainer');
if(container) {
// Add click event listener to the container
    container.addEventListener('click', function (event) {
        // Check if the clicked element has the class "add-item"
        console.log(event);

        if (event.target.classList.contains('add-item')) {
            event.preventDefault()
            document.getElementById('variations-list').style.display = 'block';
            let id = event.target.getAttribute('data-id');
            id = parseInt(id);
            id++;
            const newItemContainer = document.createElement('div');
            newItemContainer.classList.add('flex', 'items-center', 'justify-between', 'pb-4', 'mb-4', 'border-b', 'border-[#C4C4C4]');
            newItemContainer.innerHTML = `
                            <div class="">
                                <label class="block font-medium text-sm text-gray-700 text-black font-sans" for="name${id}">Name</label>
                                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full px-3 py-2" id="name${id}" type="text" name="variants[${id}][variant_name]" required="required" placeholder="Name">
                            </div>

                            <div class="">
                                <label class="block font-medium text-sm text-gray-700 text-black font-sans" for="price${id}">Price</label>
                                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full px-3 py-2" id="price${id}" type="number" step=".01" name="variants[${id}][variant_price]" required="required" placeholder="12.34">
                            </div>

                            <div class="">
                                <label class="block font-medium text-sm text-gray-700 text-black font-sans" for="image${id}">Image</label>
                                <input type="file" name="variants[${id}][variant_image]" id="image${id}">
                            </div>

                            <div>
                                <button  class="remove-item" role="button"><img style="pointer-events: none" src="/img/icons/remove.svg" alt="remove"></button>
                            </div>
                        `;
            // Append the new item container to the container
            container.appendChild(newItemContainer);
        }

        if (event.target.classList.contains('remove-item')) {
            event.preventDefault()
            console.log('clicked');
            // Get the parent of the clicked remove button (which is the item container)
            const itemContainer = event.target.parentElement.parentElement;
            // Remove the item container from the container
            itemContainer.remove();
        }


        if (event.target.classList.contains('delete-item')) {
            event.preventDefault()
console.log('delete');
            var idToRemove = event.target.getAttribute('data-remove-id');

            let input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'remove[]');
            input.setAttribute('value', idToRemove);
            document.getElementById('productUpdateForm').appendChild(input);
        }
    });
}
