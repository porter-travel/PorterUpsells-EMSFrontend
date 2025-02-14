@if($errors->any())
    <div class="bg-pink/50 border border-pink rounded-3xl p-4">
        <ul>
            @foreach($errors->all() as $error)
                <li class="text-red">{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex flex-wrap">

    {{--    {{dd($errors)}}--}}


    <div class="md:basis-1/2 basis-full md:pr-4 mt-4">
        <x-input-label class="text-black font-sans" for="image" :value="__('Product Image')"/>
        <div class="flex items-end">
            @if($product->image)
                <div class="mr-4">
                    <img src="{{$product->image}}" alt="product"
                         class="w-[64px] h-[64px] object-cover rounded-xl"/>
                </div>
            @endif
            <input @if($method == 'create') required @endif type="file" name="image" id="image">
        </div>
        <p class="text-sm text-gray-500 mt-2">Images should be 500x500 pixels in size and no larger than 1Mb.</p>
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
    <div class="flex items-center justify-between">
        <x-input-label class="text-black font-sans" :value="__('Description')"/>

{{--        <button class="bg-blue p-1 border-blue rounded-xl" type="button" id="rewriteProductDescription">✨</button>--}}
    </div>

    <div id="description" class="block mt-1 w-full px-3 py-2 rounded-b-md quill-text-editor" type="text">
        {!! $product->description !!}</div>
    <input id="realDescription" type="hidden" name="description" value="{{ $product->description }}" required>
    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toolbarOptions = ['bold', 'italic', 'underline', 'strike', [{'header': false}],];

        const quill = new Quill('#description', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],   // Text styling
                    [{'list': 'ordered'}, {'list': 'bullet'}], // Lists
                    ['clean']  // Remove formatting
                ]
            }

        });

        quill.on('text-change', (delta, oldDelta, source) => {
            document.querySelector('#realDescription').value = quill.root.innerHTML;

        });

        const btn = document.getElementById('rewriteProductDescription');
        btn.addEventListener('click', function () {
            const description = document.querySelector('#realDescription').value;
            fetch('/admin/chat/rewrite-product-descriptions', {
                method: 'POST',
                body: JSON.stringify({'product_description': description}),
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                },}).then(response => response.json()).then(data => {
                console.log(data);
                quill.root.innerHTML = data.result;
                document.querySelector('#realDescription').value = data.result;
            });
        })
    });
</script>
