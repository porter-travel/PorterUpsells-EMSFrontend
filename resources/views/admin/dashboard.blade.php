<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

        <a href="/admin/hotel/create">Add New Hotel</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                                    <a class="pl-4" href="{{route('orders.listItemsForPicking', $hotel->id)}}">View Orders</a>
                                </div>
                            @endforeach

                        </div>

                    @else

                        <h2>No Hotels Found - <a href="/admin/hotel/create">create your first hotel</a></h2>

                    @endif
                </div>
            </div>
        </div>
    </div>

    <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
    <stripe-pricing-table pricing-table-id="prctbl_1PM63SJQ5u1m2fEsuJzR9SHZ"
                          publishable-key="pk_live_51JbMvaJQ5u1m2fEsBqIUIR8xy93kpla6UHAGH9xxPgoy8pHmyKWHxwR6WGq6nSHdwBT7xPJgRgJzy6I49Qpu4sEZ00BKCRdldz">
    </stripe-pricing-table>
</x-app-layout>
