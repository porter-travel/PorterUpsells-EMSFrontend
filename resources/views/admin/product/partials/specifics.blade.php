@if(!isset($product))
    @php
        $product = new \App\Models\Product();
    @endphp
@endif


@php
    $on_arrival_checked = '';
    if(isset($product->specifics['on_arrival'])){
      if($product->specifics['on_arrival']){
         $on_arrival_checked = 'checked';
      }
    }else{
        $on_arrival_checked = 'checked';
    }
@endphp


<div class="flex items-start justify-start">
    <div class="mt-4 basis-1/2 pr-4">
        <hr>

        <h4 class="font-bold py-4">Availability</h4>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[on_arrival]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[on_arrival]" value="1" id="on_arrival" {{$on_arrival_checked }}>
            <x-input-label class="text-black font-sans" for="on_arrival"
                           :value="__('Available on date of arrival')"/>

        </div>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[during_stay]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[during_stay]" value="1" id="during_stay"
                    @checked($product->specifics['during_stay'])>
            <x-input-label class="text-black font-sans" for="during_stay"
                           :value="__('Available during stay')"/>

        </div>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[on_departure]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[on_departure]" value="1" id="on_departure"
                    @checked($product->specifics['on_departure'])>

            <x-input-label class="text-black font-sans" for="on_departure"
                           :value="__('Available on date of departure')"/>
        </div>
    </div>

    <div class="mt-4 basis-1/2 pl-4">
        <hr>

        <h4 class="font-bold py-4">Storage / Quality</h4>
        <div class="flex items-center justify-start">
            <input type="hidden" name="specifics[after_checkin]" value="0">
            <input class="mr-2" type="checkbox" name="specifics[after_checkin]" value="1" id="after_checkin"
                    @checked($product->specifics['after_checkin'])>

            <x-input-label class="text-black font-sans" for="after_checkin"
                           :value="__('Product can only be delivered after guest has checked in')"/>
        </div>
    </div>

</div>

