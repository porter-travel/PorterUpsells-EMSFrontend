<x-app-layout>
{{--    {{dd(count($keys))}}--}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fulfilment Keys
            </h2>
            <a href="{{route('fulfilment-keys.create')}}"
               class="text-black font-bold border rounded-xl p-4 hover:bg-mint">Create Fulfilment Key</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(is_countable($keys) && count($keys) > 0)

                        <div class="flex flex-wrap">
                            <table class="w-full rounded">
                                <thead>
                                <tr class="text-left bg-grey">
                                    <th class="p-2">Name</th>
                                    <th class="p-2">Properties</th>
                                    <th class="p-2">Key</th>
                                    <th class="p-2">Expires At</th>
                                    <th class="p-2 ">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($keys as $k => $key)

                                    <tr class="border">
                                        <td class="p-2">{{$key['name']}}</td>
                                        <td class="p-2"><ul>
                                                @foreach($key['hotels'] as $hotel)
                                                    <li>{{$hotel['name']}}</li>
                                                @endforeach
                                            </ul></td>
                                        <td>
                                            <input class="booking-link" type="text" disabled
                                                   value="{{env('APP_URL')}}/fulfilment/{{$k}}">
                                            <span class="copy-label cursor-pointer" onclick="copyToClipboard(this)">Copy</span>
                                        </td>
                                        <td class="p-2">{{$key['expires_at'] ? $key['expires_at'] : 'Not Expiring'}}</td>
                                        <td>
                                            <form method="post" action="{{route('fulfilment-keys.delete', ['key' => $k])}}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="key" value="{{$k}}">
                                                <button type="submit" class="text-red cursor-pointer">Delete</button>

                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>

                    @else

                        <p>No keys to show</p>
                    @endif


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
