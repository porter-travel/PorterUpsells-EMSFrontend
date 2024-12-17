<label
    class="border border-black bg-[#F7F7F7] rounded p-2 flex items-center mr-2 mb-2 fancy-checkbox">
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        style="width: 0; height: 0; opacity: 0"
        type="checkbox"
        value="1"
        name="{{ $name }}"
        id="{{ $name }}"
        @checked($isChecked)
    >
    <span class="w-[29px] h-[29px] border border-darkGrey rounded mr-2 relative"></span>
    <span></span>
    <span class="relative font-bold">{{ $label }}</span>
</label>
