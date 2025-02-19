<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-extrabold open-sans text-2xl text-black leading-tight uppercase">
            {{ __('Edit Product: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form enctype="multipart/form-data" method="post" action="/admin/product/update"
                          id="productUpdateForm">

                        @csrf

                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="hotel_id" value="{{$hotel->id}}">

                        @include('admin.product.partials.core-fields', ['method' => 'update', 'product' => $product])


                        @include('admin.product.partials.specifics', ['method' => 'update'])


                        <div id="variantContainer">
                            <div class="my-6 flex items-center justify-between flex-wrap">
                                <h3 class="text-xl mr-4">Variations</h3>


                                <div>
                                    <button data-id="{{count($product->variations) + 1}}"
                                            class="add-item flex items-center px-8 py-2 bg-mint rounded-full"
                                            role="button">
                                        <img style="pointer-events: none" src="/img/icons/plus.svg" alt="add" class="mr-2">
                                        Add a variation
                                    </button>
                                </div>
                            </div>

                            <div id="variations-list" class="@if(count($product->variations) == 1) hidden @endif">
                                <ul class="sortable-list">
                                @foreach($product->variations as $key => $variation)
                                        <li data-product-id="{{$variation->id}}" class="sortable-item flex w-full items-center justify-start">
                                            <div draggable="true" class="handle cursor-grab">
                                                <svg class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 8C10.3284 8 11 7.32843 11 6.5C11 5.67157 10.3284 5 9.5 5C8.67157 5 8 5.67157 8 6.5C8 7.32843 8.67157 8 9.5 8ZM9.5 14C10.3284 14 11 13.3284 11 12.5C11 11.6716 10.3284 11 9.5 11C8.67157 11 8 11.6716 8 12.5C8 13.3284 8.67157 14 9.5 14ZM11 18.5C11 19.3284 10.3284 20 9.5 20C8.67157 20 8 19.3284 8 18.5C8 17.6716 8.67157 17 9.5 17C10.3284 17 11 17.6716 11 18.5ZM15.5 8C16.3284 8 17 7.32843 17 6.5C17 5.67157 16.3284 5 15.5 5C14.6716 5 14 5.67157 14 6.5C14 7.32843 14.6716 8 15.5 8ZM17 12.5C17 13.3284 16.3284 14 15.5 14C14.6716 14 14 13.3284 14 12.5C14 11.6716 14.6716 11 15.5 11C16.3284 11 17 11.6716 17 12.5ZM15.5 20C16.3284 20 17 19.3284 17 18.5C17 17.6716 16.3284 17 15.5 17C14.6716 17 14 17.6716 14 18.5C14 19.3284 14.6716 20 15.5 20Z" fill="#121923"/>
                                                </svg>
                                            </div>
                                    <div class="flex flex-grow items-center justify-between pb-4 mb-4 border-b border-[#C4C4C4]">

                                        <input type="hidden" name="variants[{{$key}}][variant_id]"
                                               value="{{$variation->id}}">
                                        <div class="">
                                            <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                                   for="name">Name</label>
                                            <input value="{{$variation->name}}"
                                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full px-3 py-2"
                                                   id="name" type="text" name="variants[{{$key}}][variant_name]"
                                                   required="required" placeholder="Name">
                                        </div>

                                        <div class="">
                                            <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                                   for="price">Price</label>
                                            <input value="{{$variation->price}}"
                                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full px-3 py-2"
                                                   id="price" type="number" step=".01"
                                                   name="variants[{{$key}}][variant_price]" required="required"
                                                   placeholder="12.34">
                                        </div>

                                        <div class="">
                                            <label class="block font-medium text-sm text-gray-700 text-black font-sans"
                                                   for="image">Image</label>
                                            <img src="{{$variation->image}}" alt="product"
                                                 class="w-[100px] rounded-3xl mb-2"/>
                                            <input type="file" name="variants[{{$key}}][variant_image]" id="image">
                                        </div>

                                        <div>
                                            <button class="remove-item delete-item" role="button"
                                                    data-remove-id="{{$variation->id}}"><img
                                                    style="pointer-events: none" src="/img/icons/remove.svg"
                                                    alt="remove">
                                            </button>
                                        </div>
                                    </div>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center mt-4">Update Product</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('admin.product.partials.unavailability-modal', ['product' => $product])

    <script>
        const list = document.querySelector('.sortable-list');
        let draggingItem = null;

        // Enable dragging only when clicking the handle
        list.addEventListener('dragstart', (e) => {
            console.log(e.target.closest('.handle'))
            console.log(e.target)
            const handle = e.target.closest('.handle'); // Check if handle was clicked
            if (!handle) {
                e.preventDefault();
                return;
            }
            draggingItem = handle.closest('.sortable-item'); // Get the parent li
            draggingItem.classList.add('dragging');
        });

        // Remove dragging styles
        list.addEventListener('dragend', () => {
            if (draggingItem) {
                draggingItem.classList.remove('dragging');
                draggingItem = null;
            }

            document.querySelectorAll('.sortable-item').forEach(item => item.classList.remove('over'));

            // Collect the ordered product IDs
            const orderedProductIds = [...document.querySelectorAll('.sortable-item')]
                .map(item => item.dataset.productId);

            // Send the order to the server
            fetch('/admin/product/update-variant-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Ensure you have a CSRF token meta tag in your HTML
                },
                body: JSON.stringify({ variant_ids: orderedProductIds, hotel_id: {{$hotel->id}} })
            })
                .then(response => response.json())
                .then(data => console.log('Order updated:', data))
                .catch(error => console.error('Error updating order:', error));
        });


        // Handle drag over events
        list.addEventListener('dragover', (e) => {
            e.preventDefault();
            const draggingOverItem = getDragAfterElement(list, e.clientY);
            document.querySelectorAll('.sortable-item').forEach(item => item.classList.remove('over'));

            if (draggingOverItem) {
                draggingOverItem.classList.add('over');
                list.insertBefore(draggingItem, draggingOverItem);
            } else {
                list.appendChild(draggingItem);
            }
        });

        // Get the element to insert after
        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.sortable-item:not(.dragging)')];
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                return offset < 0 && offset > closest.offset ? { offset, element: child } : closest;
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

    </script>

</x-hotel-admin-layout>
