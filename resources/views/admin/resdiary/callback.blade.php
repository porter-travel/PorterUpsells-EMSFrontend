<x-app-layout>
    <x-slot name="header">
        <h2 class="grandstander text-2xl">ResDiary Connection</h2>
    </x-slot>

    <div class="container mx-auto">

        @if($status == 'success')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">ResDiary has been successfully connected.</span>
            </div>

        @elseif($status = 'pending_hotel_selection')
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <p>Please Select the hotel you would like to connect with ResDiary</p>
                <form method="post" action="/resdiary/set-hotel">
                <select>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                    @endforeach
                </select>
                    <x-primary-button>Select</x-primary-button>
                </form>
            </div>

        @else

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">There was an error connecting to ResDiary. Please contact support</span>
            </div>

        @endif
    </div>

</x-app-layout>
