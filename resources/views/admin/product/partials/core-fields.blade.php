<div class="flex flex-wrap">
    <div class="md:basis-1/2 basis-full md:pr-4 mt-4">
        <x-input-label class="text-black font-sans" for="image" :value="__('Product Image')"/>
        <div class="flex items-end">
            @if($product->image)
                <div class="mr-4">
                    <img src="{{$product->image}}" alt="product"
                         class="w-[64px] h-[64px] object-cover rounded-xl"/>
                </div>
            @endif
            <input type="file" name="image" id="image">
        </div>
    </div>

    <div class="md:basis-1/2 basis-full md:pr-4 mt-4 text-right">
        <x-input-label class="text-black font-sans sr-only" for="status" :value="__('Status')"/>
        <select class="border-[#C4C4C4] rounded-md" name="status" id="status">
            <option {{$product->status == 'active' ? 'selected' : ''}} value="active">Active
            </option>
            <option {{$product->status == 'inactive' ? 'selected' : ''}} value="inactive">
                Inactive
            </option>
            <option {{$product->status == 'draft' ? 'selected' : ''}} value="draft">Draft
            </option>
        </select>
    </div>
</div>
<div class="flex flex-wrap">
    <div class="md:basis-1/2 basis-full md:pr-4 mt-4">
        <x-input-label class="text-black font-sans" for="name" value="Name"/>
        <x-text-input id="name" class="block mt-1 w-full px-3 py-2" type="text" name="name"
                      :value="$product->name"
                      required placeholder="Name"/>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>

    <div class="md:basis-1/2 basis-full md:pl-4 mt-4">
        <x-input-label class="text-black font-sans" for="price" :value="__('Price')"/>
        <x-text-input id="price" class="block mt-1 w-full px-3 py-2" type="number" name="price"
                      :value="$product->price"
                      required step=".01" placeholder="12.34"/>
        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
    </div>
</div>
<div class="mt-4">
    <x-input-label class="text-black font-sans" for="name" :value="__('Description')"/>
    <textarea id="description" class="block mt-1 w-full px-3 py-2 rounded-md" type="text"
              name="description"
              required>{{$product->description}}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
</div>
