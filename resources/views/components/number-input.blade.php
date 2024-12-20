<div class="number-input flex items-center justify-center border rounded px-3 bg-[#F7F7F7]">
    <span class="number-input-minus cursor-pointer">-</span>
    <input id="{{$id ?? null}}"  name="{{$key}}" @if(isset($max)) max="{{$max}}" @endif type="number" min="1"
           value="{{$quantity}}"
           class="cart-product-quantity mx-2 w-10 text-center border-0 bg-[#F7F7F7]">
    <span class="number-input-plus cursor-pointer">+</span>
</div>
