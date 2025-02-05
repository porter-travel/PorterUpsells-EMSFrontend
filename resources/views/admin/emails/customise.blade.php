@php use App\Helpers\Money; @endphp
<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emails') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-8">
                        Pre-Arrival Email Schedule
                    </h2>

                    <form method="post" action="{{route('email.store-customisations', $hotel->id)}}" class="">
                        @csrf
                        <div class="flex">
                            <div>

                                <x-fancy-checkbox dusk="pre-arrival-email"


                                                  :isChecked="(!empty($email_schedule) && isset($email_schedule['email-schedule-2-day-pre-arrival'])) ? $email_schedule['email-schedule-2-day-pre-arrival'] : true"

                                                  name="hotel_meta[email-schedule-2-day-pre-arrival]"
                                                  label="2 days pre-arrival"/>
                            </div>
                            <div>
                                <x-fancy-checkbox dusk="pre-arrival-email"
                                                  :isChecked="(!empty($email_schedule) && isset($email_schedule['email-schedule-7-day-pre-arrival'])) ? $email_schedule['email-schedule-7-day-pre-arrival'] : true"
                                                  name="hotel_meta[email-schedule-7-day-pre-arrival]"
                                                  label="7 days pre-arrival"/>
                            </div>
                            <div>
                                <x-fancy-checkbox dusk="pre-arrival-email"
                                                  :isChecked="(!empty($email_schedule) && isset($email_schedule['email-schedule-14-day-pre-arrival'])) ? $email_schedule['email-schedule-14-day-pre-arrival'] : true"
                                                  name="hotel_meta[email-schedule-14-day-pre-arrival]"
                                                  label="14 days pre-arrival"/>
                            </div>
                            <div>
                                <x-fancy-checkbox dusk="pre-arrival-email"
                                                  :isChecked="(!empty($email_schedule) && isset($email_schedule['email-schedule-30-day-pre-arrival'])) ? $email_schedule['email-schedule-30-day-pre-arrival'] : true"
                                                  name="hotel_meta[email-schedule-30-day-pre-arrival]"
                                                  label="30 days pre-arrival"/>
                            </div>
                        </div>
                        <div class="flex items-end justify-end">
                            <x-primary-button dusk="save-pre-arrival-email" class="mt-4">Save</x-primary-button>
                        </div>
                    </form>

                    <div class="border-t border-[#C4C4C4] mt-4 pt-4">
                        <form method="post" action="{{route('email.store-customisations', $hotel->id)}}">
                            <input type="hidden" name="hotel_email[email_type]" value="pre-arrival-email">
                            @csrf
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-8">
                                Pre-Arrival Email Setup
                            </h2>

                            <div class="border rounded-3xl border-darkGrey p-4">

                                <table class="body-wrap"
                                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
                                       bgcolor="#f6f6f6">
                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                                            valign="top"></td>
                                        <td class="container" width="800"
                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 800px !important; clear: both !important; margin: 0 auto;"
                                            valign="top">
                                            <div class="content"
                                                 style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 800px; display: block; margin: 0 auto; padding: 20px;">
                                                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                                                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;"
                                                       bgcolor="#fff">
                                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                        <td
                                                            background="{{$hotel->featured_image}}"
                                                            class=""
                                                            style="background:url({{$hotel->featured_image}}) no-repeat center center / cover; height: 250px;"
                                                            align="center" bgcolor="" valign="top">
                                                            <table
                                                                style="width: 100%; background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);">
                                                                <tr>
                                                                    <td style="height: 150px">

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: left; padding: 16px">
                                                                        <table>
                                                                            <tr>
                                                                                <td>
                                                                                    <img src="{{$hotel->logo}}"
                                                                                         alt="hotel"
                                                                                         style="width: 100px; height: auto; border-radius: 4px; object-fit: contain"/>

                                                                                </td>
                                                                                <td>
                                                                                    <p
                                                                                        style="color: white; font-size: 24px; font-weight: bold; margin-left: 16px">{{$hotel->name}}</p>

                                                                                </td>
                                                                            </tr>
                                                                        </table>

                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 16px">
                                                            <p class="text-xl">Key Message</p>
                                                            <textarea
                                                                name="hotel_email[key-message]"
                                                                cols="10" rows="10"
                                                                class="w-full h-[200px] rounded-2xl">{{$email_content->key_message}}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 16px; text-align: center">
                                                        <span
                                                            style="background-color: {{$hotel->button_color}}; font-weight: bold; padding: 16px; text-decoration: none; border-radius: 4px">
                                                            <x-text-input
                                                                name="hotel_email[button-text]"
                                                                type="text"
                                                                value="{{$email_content->button_text}}"/></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 8px">
                                                            <p class="text-xl">Highlight Specific Products</p>
                                                            <table style="width: 100%; table-layout: fixed">
                                                                <tr>

                                                                    @foreach($email_content->featured_products as $key => $product)
                                                                        <td style="padding: 8px; vertical-align: top; position: relative">
                                                                            <a data-slot-id="{{$key}}"
                                                                               class=" featuredProductLink" href="#">
                                                                                @if((is_numeric($product) && ($product == 0 || $product == '0')) || $product == null)
                                                                                    <div
                                                                                        class=" flex pointer-events-none items-center justify-center border-darkGrey border rounded-2xl h-[150px] p-4">
                                                                                        <img src="/img/icons/plus.svg"
                                                                                             alt="plus"
                                                                                             class=" w-8 h-8 pointer-events-none"/>


                                                                                    </div>
                                                                                @else

                                                                                    <div class="">
                                                                                        <img src="{{$product->image}}"
                                                                                             alt="{{$product->name}}"
                                                                                             class="w-full h-[150px] object-cover rounded-2xl"/>
                                                                                        <p class="left">{{$product->name}}</p>
                                                                                        <strong>{{\App\Helpers\Money::lookupCurrencySymbol($hotel->user->currency)}}{{Money::format($product->price)}}</strong>
                                                                                    </div>
                                                                                @endif


                                                                                <input type="hidden"
                                                                                       name="hotel_email[featured-products][]"
                                                                                       value="{{$product ? $product->id : null}}">
                                                                            </a>

                                                                            <a href="#">
                                                                                <img src="/img/icons/remove.svg"
                                                                                     alt="remove"
                                                                                     data-remove-slot-id="{{$key}}"
                                                                                     class="remove-icon absolute top-0 right-0 w-6 h-6"/>
                                                                            </a>
                                                                        </td>

                                                                    @endforeach


                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="padding: 16px">
                                                            <p class="text-xl">Additional Information</p>
                                                            <textarea name="hotel_email[additional-information]"
                                                                      cols="10" rows="10"
                                                                      class="w-full h-[200px] rounded-2xl">{{$email_content['additional_information']}}</textarea>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </td>
                                        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                                            valign="top"></td>
                                    </tr>
                                </table>

                            </div>
                            <div class="flex items-end justify-end">
                                <x-primary-button dusk="save-pre-arrival-email-setup" class="mt-4">Save
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                    <div class="border-t border-[#C4C4C4] mt-4 pt-4">
                        <form method="post" action="{{route('email.store-customisations', $hotel->id)}}">
                            @csrf
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-8">
                                Order Confirmation Email
                            </h2>
                            <p class="text-large">Send a copy of any order confirmation emails to the following
                                addresses
                                (separate with a comma)</p>
                            <x-text-input
                                name="hotel_meta[email-recipients]" type="text" value="{{$email_recipients}}"
                                class="w-full"/>

                            <div class="flex items-end justify-end">
                                <x-primary-button dusk="save-pre-arrival-email-setup" class="mt-4">Save
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const featuredProductLinks = document.querySelectorAll('.featuredProductLink');

            featuredProductLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    const slotId = e.currentTarget.dataset.slotId
                    console.log('target', e.target);
                    console.log('slotIDoutside', slotId);
                    //Make post request to route product.list-as-json to get products
                    //Add csrf token to the request

                    fetch('/admin/hotel/{{$hotel->id}}/list-products-as-json', {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        method: 'post'
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            //Create a modal with the products
                            const modal = document.createElement('div');
                            modal.classList.add('fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'bg-black/20', 'flex', 'justify-center', 'items-center');
                            modal.innerHTML = `
                                <div class="bg-white p-4 rounded-2xl">
                                    <h2 class="text-xl font-bold">Select a product</h2>
                                    <ul>
                                        ${data.map(product => {
                                return `<li class="flex items-center justify-between border-b border-gray-300 p-2">
                                                   <img src="${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded"/>
                                                    <div class="flex flex-col flex-grow pl-2">
                                                        <span class="text-left">${product.name}</span>
                                                    <div class="text-right">
                                                        <button data-product-id="${product.id}" class="addProduct bg-black text-white px-4 py-1 rounded-full">Add</button>
                                                    </div>
                                                    </div>
                                            </li>`
                            }).join('')}
                                    </ul>
                                </div>
                            `;
                            document.body.appendChild(modal);
                            //Add event listener to the add button

                            setupAddProductButtons(slotId, modal)

                        });
                }, false);

            });

            const setupAddProductButtons = (slotId, modal) => {
                const addProductButtons = document.querySelectorAll('.addProduct');

                addProductButtons.forEach(button => {
                    button.addEventListener('click', function (e) {
                        const productId = button.getAttribute('data-product-id');
                        //Make a post request to get the product as json
                        let productData = getProductAsJson(productId);

                        productData.then(data => {
                            console.log(data);
                            //Update the image and name of the product in the slot
                            const slot = document.querySelector(`[data-slot-id="${slotId}"]`);
                            console.log('slotId', slotId);
                            slot.innerHTML = `
                                            <img src="${data.image}" alt="${data.name}" class="w-full h-[150px] object-cover rounded-2xl"/>
                                            <p class="text-left">${data.name}</p>
                                            <strong>{{\App\Helpers\Money::lookupCurrencySymbol($hotel->user->currency)}}${data.price}</strong>
                                        `;
                            //Add the product id to the hidden input
                            const input = document.createElement('input');
                            input.setAttribute('type', 'hidden');
                            input.setAttribute('name', 'hotel_email[featured-products][]');
                            input.setAttribute('value', data.id);
                            slot.appendChild(input);
                            //Remove the modal
                            modal.remove();
                            //Show the remove icon
                            const removeIcon = document.querySelector(`[data-remove-slot-id="${slotId}"`);
                            removeIcon.classList.remove('hidden');

                        })
                    })
                });
            }


            const getProductAsJson = (productId) => {
                return fetch('/admin/product/' + productId + '/get-as-json', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    method: 'post'
                })
                    .then(response => response.json())
                    .then(data => {
                        return data;
                    });

            }
        });

        const removeIcon = document.querySelectorAll('.remove-icon');

        removeIcon.forEach(icon => {
            icon.addEventListener('click', function (e) {
                e.preventDefault();
                const slotId = e.currentTarget.dataset.removeSlotId;
                const slot = document.querySelector(`[data-slot-id="${slotId}"]`);
                slot.innerHTML = `
                    <div class="flex  items-center justify-center border-darkGrey border rounded-2xl h-[150px] p-4">
                        <img src="/img/icons/plus.svg" alt="plus" class=" w-8 h-8"/>
                    </div>
                    <input type="hidden" name="hotel_email[featured-products][]" value="0">
                `;
                icon.classList.add('hidden');
            });
        });


    </script>
</x-hotel-admin-layout>
