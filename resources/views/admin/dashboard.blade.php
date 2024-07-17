<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

        @if($user->stripe_account_active)
            <a href="/admin/hotel/create">Add New Hotel</a>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($user->stripe_account_active)
                        @if(count($hotels) > 0)

                            <h2 class="text-2xl font-bold mb-6">Your Hotels</h2>
                            <div class="flex flex-wrap">
                                @foreach($hotels as $hotel)
                                    <div class="basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4">
                                        <a class="p-4 block" href="/admin/hotel/{{$hotel->id}}/edit">
                                            <div class="">
                                                <img
                                                    src="{{$hotel->logo}}" alt="hotel" class="w-full rounded-3xl mb-2"/>
                                                <h3 class="text-lg font-bold">{{$hotel->name}}</h3>
                                            </div>
                                        </a>

                                        <a class="pl-4" href="{{route('orders.listItemsForPicking', $hotel->id)}}">View
                                            Orders</a><br>
                                        <a class="pl-4" href="{{route('bookings.list', $hotel->id)}}">View Guests</a>
                                    </div>
                                @endforeach

                            </div>

                        @else

                            <h2>No Hotels Found - <a href="/admin/hotel/create">create your first hotel</a></h2>

                        @endif
                    @else
                        <h2 class="text-2xl mb-6">We just need to setup your payment account, and then you can start adding hotels.</h2>
                        <a href="{{route('profile.edit')}}">
                            <x-primary-button>Click Here</x-primary-button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
