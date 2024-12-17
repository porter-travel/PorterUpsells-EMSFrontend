<p class="open-sans text-2xl mb-6">Colour Scheme</p>
@csrf

<div class="flex flex-wrap justify-between my-4">
    @php
        $colors = [
            ['id' => 'primary_color', 'label' => 'Background', 'name' => 'page_background_color', 'value' => $hotel->page_background_color ?? '#ffffff'],
            ['id' => 'main_box_color', 'label' => 'Main Box', 'name' => 'main_box_color', 'value' => $hotel->main_box_color ?? '#F5D6E1'],
            ['id' => 'main_box_text_color', 'label' => 'Main Box Text', 'name' => 'main_box_text_color', 'value' => $hotel->main_box_text_color ?? '#000000'],
            ['id' => 'button_color', 'label' => 'Button', 'name' => 'button_color', 'value' => $hotel->button_color ?? '#D4F6D1'],
            ['id' => 'accent_color', 'label' => 'Accent', 'name' => 'accent_color', 'value' => $hotel->accent_color ?? '#C7EDF2'],
            ['id' => 'text_color', 'label' => 'Text', 'name' => 'text_color', 'value' => $hotel->text_color ?? '#000000'],
            ['id' => 'button_text_color', 'label' => 'Button Text', 'name' => 'button_text_color', 'value' => $hotel->button_text_color ?? '#000000'],
        ];
    @endphp

    @foreach ($colors as $color)
        <div class="flex items-start lg:basis-[13%] md:basis-1/4 basis-1/2 flex-col mb-4 px-2">
            <x-color-input id="{{ $color['id'] }}" class="mr-2 aspect-square w-[64px] h-[64px] rounded-md" type="color" name="{{ $color['name'] }}" :value="$color['value']" />
            <x-input-label class="text-black font-sans mr-2" for="{{ $color['id'] }}" :value="__($color['label'])" />
            <input
                type="text"
                id="{{ $color['id'] }}_hex"
                class="border-[#C4C4C4] w-full rounded-md"
                maxlength="7"
                value="{{ $color['value'] }}"
            />
        </div>
    @endforeach
</div>

<script>
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        const hexInput = document.getElementById(`${colorInput.id}_hex`);

        // Sync hex input with color picker
        colorInput.addEventListener('input', () => {
            hexInput.value = colorInput.value.toUpperCase();
        });

        // Sync color picker with hex input
        hexInput.addEventListener('input', () => {
            const hexValue = hexInput.value.trim();
            if (/^#[0-9A-Fa-f]{6}$/.test(hexValue)) {
                colorInput.value = hexValue;
            }
        });

        // Handle pasting into the hex input
        hexInput.addEventListener('paste', (e) => {
            const pastedData = e.clipboardData.getData('text').trim();
            if (/^#[0-9A-Fa-f]{6}$/.test(pastedData)) {
                hexInput.value = pastedData;
                colorInput.value = pastedData;
            }
            e.preventDefault();
        });
    });
</script>
