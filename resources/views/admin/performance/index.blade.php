<x-app-layout>
    {{--    {{dd(count($keys))}}--}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Performance For: {{$hotel ? $hotel->name : 'All Properties'}}
            </h2>

            <div id="product-selector" class="border rounded flex justify-between relative">
                <span class="p-2">
                {{$hotel ? $hotel->name : 'All Properties'}}
                    </span>
                <ul class="w-fit right-0 border rounded p-2 hidden absolute bg-white top-full">
                    @php
                        $queryString = request()->getQueryString();
                        $queryString = $queryString ? '?' . $queryString : '';
                    @endphp

                    <li class="@if(!$hotel) hidden @endif">
                        <a class="whitespace-nowrap" href="{{ route('performance.index') . $queryString }}">
                            All Properties
                        </a>
                    </li>
                    @foreach($hotels as $loopHotel)
                        <li class="@if($hotel && $hotel->id == $loopHotel->id) hidden @endif">
                            <a class="whitespace-nowrap"
                               href="{{ route('performance.index', ['hotel_id' => $loopHotel->id]) . $queryString }}">
                                {{$loopHotel->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <button class="bg-lightBlue rounded p-2 flex items-center">
                    <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 8L15 0H0L7.5 8Z" fill="black"/>
                    </svg>
                </button>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-date-filter-bar :startDate="$startDate" :endDate="$endDate"/>

                    <div class="flex items-start justify-start flex-wrap">
                        <div class="basis-1/3 p-4">
                            <div class="border border-darkGrey rounded-3xl p-4">
                                <p class="font-bold text-center text-xl">Dashboard Views</p>
                                <p class="font-bold text-center text-4xl">{{$totalDashboardViews}}</p>
                            </div>
                        </div>

                        <div class="basis-1/3 p-4">
                            <div class="border border-darkGrey rounded-3xl p-4">
                                <p class="font-bold text-center text-xl">Product Views</p>
                                <p class="font-bold text-center text-4xl">{{$totalProductViews}}</p>
                            </div>
                        </div>

                        {{--                        <div class="basis-1/3 p-4">--}}
                        {{--                            <div class="border border-darkGrey rounded-3xl p-4">--}}
                        {{--                                <p class="font-bold text-center text-xl">Cart Views</p>--}}
                        {{--                                <p class="font-bold text-center text-4xl">{{$totalCartViews}}</p>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="basis-1/3 p-4">
                            <div class="border border-darkGrey rounded-3xl p-4">
                                <p class="font-bold text-center text-xl">Orders</p>
                                <p class="font-bold text-center text-4xl">{{$totalOrders}}</p>
                            </div>
                        </div>

                        <div class="basis-1/3 p-4">
                            <div class="border border-darkGrey rounded-3xl p-4">
                                <p class="font-bold text-center text-xl">Adds To Cart</p>
                                <p class="font-bold text-center text-4xl">{{$totalAddsToCart}}</p>
                            </div>
                        </div>

                        <div class="basis-1/3 p-4">
                            <div class="border border-darkGrey rounded-3xl p-4">
                                <p class="font-bold text-center text-xl">Emails Sent</p>
                                <p class="font-bold text-center text-4xl">{{$emailCount}}</p>
                            </div>
                        </div>

                        <div class="basis-1/3 p-4">
                            <div class="border border-darkGrey rounded-3xl p-4">
                                <p class="font-bold text-center text-xl">Total Revenue</p>
                                <p class="font-bold text-center text-4xl">
                                    £{{\App\Helpers\Money::format($totalSales)}}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-8">Property Performance</h2>
                @if(!$hotel && count($hotelOrders) > 0)
                    <table id="hotelOrdersTableBody" class="w-full">
                        <thead>
                        <tr>
                            <th
                                class="bg-darkGrey text-white text-left p-2 rounded-tl cursor-pointer"
                                data-sort="hotel_name"
                            >
                                Property <span class="sort-arrow"></span>
                            </th>
                            <th
                                class="bg-darkGrey text-white text-left p-2 cursor-pointer"
                                data-sort="total_orders"
                            >
                                Total Orders <span class="sort-arrow"></span>
                            </th>
                            <th
                                class="bg-darkGrey text-white text-left p-2 rounded-tr cursor-pointer"
                                data-sort="total_value"
                            >
                                Total Value <span class="sort-arrow"></span>
                            </th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($hotelOrders as $hotelOrder)
                            <tr class="border border-darkGrey">
                                <td class="p-2" data-key="hotel_name">{{$hotelOrder['hotel_name']}}</td>
                                <td class="p-2" data-key="total_orders">{{$hotelOrder['total_orders']}}</td>
                                <td class="p-2" data-key="total_value">£{{\App\Helpers\Money::format($hotelOrder['total_value'])}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-8">Product Performance</h2>
                @if(count($productAnalytics) > 0)
                    <table id="productOrdersTableBody" class="w-full">
                        <thead>
                        <tr>
                            <th
                                class="bg-darkGrey text-white text-left p-2 rounded-tl cursor-pointer"
                                data-sort="hotel_name"
                            >
                                Product <span class="sort-arrow"></span>
                            </th>
                            <th
                                class="bg-darkGrey text-white text-left p-2 cursor-pointer"
                                data-sort="total_orders"
                            >
                                Total Orders <span class="sort-arrow"></span>
                            </th>
                            <th
                                class="bg-darkGrey text-white text-left p-2 rounded-tr cursor-pointer"
                                data-sort="total_value"
                            >
                                Total Value <span class="sort-arrow"></span>
                            </th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($productAnalytics as $product)
                            <tr class="border border-darkGrey">
                                <td class="p-2" data-key="hotel_name">{{$product['product_name']}}</td>
                                <td class="p-2" data-key="total_orders">{{$product['quantity']}}</td>
                                <td class="p-2" data-key="total_value">£{{$product['total_value']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>


        </div>

    </div>

    <script>

        const productSelector = document.getElementById('product-selector');
        const productSelectorList = productSelector.querySelector('ul');
        const productSelectorButton = productSelector.querySelector('button');

        productSelectorButton.addEventListener('click', () => {
            productSelectorList.classList.toggle('hidden');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Function to handle sorting for any table
            const sortTable = (tableBody, headers) => {
                headers.forEach(header => {
                    header.addEventListener('click', () => {
                        const sortKey = header.getAttribute('data-sort');
                        const rows = Array.from(tableBody.querySelectorAll('tr'));
                        const isDescending = header.classList.toggle('descending');

                        // Clear arrows from all headers
                        headers.forEach(h => h.querySelector('.sort-arrow').textContent = '');

                        // Set the arrow for the clicked header
                        const arrow = isDescending ? ' ↓' : ' ↑';
                        header.querySelector('.sort-arrow').textContent = arrow;

                        // Sort rows based on the clicked header
                        rows.sort((a, b) => {
                            const cellA = a.querySelector(`[data-key="${sortKey}"]`)?.textContent.trim() || '';
                            const cellB = b.querySelector(`[data-key="${sortKey}"]`)?.textContent.trim() || '';

                            // Handling numeric sorting for total_orders and total_value columns
                            if (sortKey === 'total_orders' || sortKey === 'total_value') {
                                const valueA = parseFloat(cellA.replace(/[^0-9.-]+/g, '')) || 0;
                                const valueB = parseFloat(cellB.replace(/[^0-9.-]+/g, '')) || 0;
                                return isDescending ? valueB - valueA : valueA - valueB;
                            }

                            // Default string comparison
                            return isDescending ? cellB.localeCompare(cellA) : cellA.localeCompare(cellB);
                        });

                        // Re-add sorted rows to the table
                        rows.forEach(row => tableBody.appendChild(row));
                    });
                });
            };

            // Hotel Orders Table Sorting
            const hotelOrdersTableBody = document.querySelector('#hotelOrdersTableBody tbody');
            const hotelOrdersHeaders = document.querySelectorAll('#hotelOrdersTableBody thead th[data-sort]');
            console.log("Hotel Orders Headers:", hotelOrdersHeaders); // Check if headers are selected

            const defaultHotelSortHeader = document.querySelector('#hotelOrdersTableBody th[data-sort="total_value"]');
            if (defaultHotelSortHeader) {
                defaultHotelSortHeader.classList.add('descending');
                defaultHotelSortHeader.querySelector('.sort-arrow').textContent = ' ↓';
            }
            if (hotelOrdersTableBody) {
                sortTable(hotelOrdersTableBody, hotelOrdersHeaders);
            }

            // Product Orders Table Sorting
            const productOrdersTableBody = document.querySelector('#productOrdersTableBody tbody');
            const productOrdersHeaders = document.querySelectorAll('#productOrdersTableBody thead th[data-sort]');
            console.log("Product Orders Headers:", productOrdersHeaders); // Check if headers are selected

            const defaultProductSortHeader = document.querySelector('#productOrdersTableBody th[data-sort="total_value"]');
            if (defaultProductSortHeader) {
                defaultProductSortHeader.classList.add('descending');
                defaultProductSortHeader.querySelector('.sort-arrow').textContent = ' ↓';
            }
            if (productOrdersTableBody) {
                sortTable(productOrdersTableBody, productOrdersHeaders);
            }
        });




    </script>


</x-app-layout>
