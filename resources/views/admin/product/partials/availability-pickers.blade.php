@if($type == 'standard')
    {{-- If the "type" is null we're looking at a classic / standard product which should be set --}}
    <div class="lg:basis-1/2 basis-full">
        <h4 class="font-bold pb-4">Availability</h4>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[on_arrival]" value="0">

            <x-fancy-checkbox
                label="Available on date of arrival"
                name="specifics[on_arrival]"
                :isChecked="isset($product->specifics['on_arrival']) ? $product->specifics['on_arrival'] : true"
            />

        </div>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[during_stay]" value="0">

            <x-fancy-checkbox
                label="Available during stay"
                name="specifics[during_stay]"
                :isChecked="isset($product->specifics['during_stay']) ? $product->specifics['during_stay'] : false"
            />


        </div>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[on_departure]" value="0">

            <x-fancy-checkbox
                label="Available on date of departure"
                name="specifics[on_departure]"
                :isChecked="isset($product->specifics['on_departure']) ? $product->specifics['on_departure'] : false"
            />

        </div>
    </div>
@else
    {{-- If the "type" is not null we're looking at a restaurant or calendar product so the availability should be throughout --}}
    <input type="hidden" name="specifics[on_departure]" value="1">
    <input type="hidden" name="specifics[on_arrival]" value="1">
    <input type="hidden" name="specifics[during_stay]" value="1">

@endif
