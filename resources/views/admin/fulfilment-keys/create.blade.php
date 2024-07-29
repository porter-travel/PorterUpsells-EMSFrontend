<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Fulfilment Key
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="post" action="{{route('fulfilment-keys.store')}}">
                        @csrf
                        <div class="flex flex-col items">
                            <div class="mt-4">
                                <x-input-label class="text-black font-sans" for="name" :value="__('Name')"/>
                                <x-text-input id="name" class="block mt-1 w-full p-4" type="text" name="name"
                                              :value="old('name')"
                                              required placeholder="Name"/>
                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                            </div>

                            <div class="mt-4">
                                <x-input-label class="text-black font-sans" for="expires_at" :value="__('Expires At')"/>
                                <x-text-input id="expires_at" class="block mt-1 w-full p-4" type="date"
                                              name="expires_at" :value="old('expires_at')"
                                              placeholder="Expires At"/>
                                <x-input-error :messages="$errors->get('expires_at')" class="mt-2"/>
                            </div>

                            <div class="mt-4">
                                <div class="flex items-start flex-wrap">
                                @foreach($hotels as $hotel)
                                    <div class="md:basis-1/3 basis-full flex items-center">
                                        <input type="checkbox" class="mr-2" name="hotel[]" id="{{$hotel->id}}"
                                               value="{{$hotel->id}}"/>
                                    <x-input-label class="text-black font-sans !mb-0" :for="$hotel->id"
                                                   :value="__($hotel->name)"/>

                                    </div>
                                @endforeach
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-secondary-button type="submit">Create Fulfilment Key</x-secondary-button>
                            </div>


                        </div>
                </div>
            </div>
        </div>

        <script>
            function copyToClipboard(element) {
                const input = element.previousElementSibling;
                if (input && input.value) {
                    // Create a temporary textarea element to hold the input value
                    const tempTextArea = document.createElement('textarea');
                    tempTextArea.value = input.value;
                    document.body.appendChild(tempTextArea);
                    tempTextArea.select();
                    try {
                        document.execCommand('copy');
                        element.innerText = 'Copied';
                        setTimeout(() => {
                            element.innerText = 'Copy';
                        }, 2000);
                    } catch (err) {
                        console.error('Unable to copy', err);
                    }
                    document.body.removeChild(tempTextArea);
                }
            }
        </script>
</x-app-layout>
