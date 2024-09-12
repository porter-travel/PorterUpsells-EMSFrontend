<div id="unavailabilityModal" class="fixed z-50 inset-0 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white w-1/2 h-1/3 rounded-3xl p-6 relative">
        <button type="button" id="closeUnavailabilityModal" class="absolute top-0 right-0 p-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <form id="unavailabilityForm" method="post" action="/admin/product/{{$product->id}}/unavailability/store">
            @csrf
            <h3 class="font-bold mb-12">Select period this product will be unavailable</h3>
            <div class="flex">
                <div class="basis-1/2">
                    <div class="flex items-center mb-6">
                        <x-input-label class="text-black font-sans !mb-0 w-[100px]" for="unavailable_from"
                                       :value="__('From')"/>
                        <input type="date" name="start_at" id="unavailable_from">
                    </div>

                    <div class="flex items-center mb-6 ">
                        <x-input-label class="text-black font-sans !mb-0 w-[100px]" for="unavailable_to"
                                       :value="__('To')"/>
                        <input type="date" name="end_at" id="unavailable_to">
                    </div>
                </div>
                <div class="basis-1/2">
                    <label
                        class="border border-black bg-[#F7F7F7] rounded p-2 inline-flex items-center mr-2 mb-2 basis-1/3 fancy-checkbox">
                        <input type="hidden" name="is_recurrent" value="0">
                        <input
                            style="width: 0; height: 0; opacity: 0"
                            type="checkbox"
                            name="is_recurrent" value="1"
                            id="is_recurrent"
                        >
                        <span class="w-[29px] h-[29px] border border-darkGrey rounded mr-2 relative"></span>
                        <span></span>
                        <span class="relative">
                        <span class="font-bold">Is Recurrent</span>
                    </span>
                    </label>

                    <div class=" mt-6 ">
                        <x-secondary-button type="submit" class="w-1/2 justify-center">Save</x-secondary-button>
                    </div>

                </div>
            </div>


        </form>
    </div>
</div>
