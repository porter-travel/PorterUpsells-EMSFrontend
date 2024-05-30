
@csrf

<div class="flex flex-wrap my-4">
    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="secondary_color" :value="__('Page Background Colour')"/>
        <x-color-input id="primary_color" class="block mt-1 w-1/2" type="color" name="page_background_color"
                       :value="$hotel->page_background_color ?? '#ffffff'"
        />
    </div>

    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="main_box_color" :value="__('Main Box Colour')"/>
        <x-color-input id="main_box_color" class="block mt-1 w-1/2" type="color" name="main_box_color"
                       :value="$hotel->main_box_color ?? '#F5D6E1'"
                       />
    </div>

    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="main_box_text_color" :value="__('Main Box Text Colour')"/>
        <x-color-input id="main_box_text_color" class="block mt-1 w-1/2" type="color" name="main_box_text_color"
                       :value="$hotel->main_box_text_color ?? '#000000'"
                       />
    </div>

    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="button_color" :value="__('Button Colour')"/>
        <x-color-input id="button_color" class="block mt-1 w-1/2" type="color" name="button_color"
                       :value="$hotel->button_color ?? '#D4F6D1'"
                       />
    </div>

    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="accent_color" :value="__('Accent Colour')"/>
        <x-color-input id="accent_color" class="block mt-1 w-1/2" type="color" name="accent_color"
                       :value="$hotel->accent_color ?? '#C7EDF2'"
                       />
    </div>

    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="text_color" :value="__('Text Colour')"/>
        <x-color-input id="text_color" class="block mt-1 w-1/2" type="color" name="text_color"
                       :value="$hotel->text_color ?? '#000000'"
                       />
    </div>

    <div class="basis-1/4">
        <x-input-label class="text-black font-sans" for="button_text_color" :value="__('Button Text Colour')"/>
        <x-color-input id="button_text_color" class="block mt-1 w-1/2" type="color" name="button_text_color"
                       :value="$hotel->button_text_color ?? '#000000'"
                       />
    </div>
</div>
