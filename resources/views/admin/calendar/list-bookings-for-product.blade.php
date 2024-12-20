<x-hotel-admin-layout :hotel="$hotel">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar Orders for: ') . $product->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="get">
                        @csrf
                        <div class="flex items-center pb-6">
                            <div class="mx-4">
                                <label>Date
                                    <input type="date" name="date" value="{{$date}}"></label>
                            </div>
                            <div>
                                <x-secondary-button type="submit">Filter</x-secondary-button>
                            </div>
                        </div>
                    </form>

                    <div class="flex h-screen">
                        @foreach($availableTimes as $availability)
                            <div class="h-screen basis-1/6 px-1">
                                <div class="h-full bg-[#f7f7f7] flex flex-col items-start justify-between">
                                    @foreach($availability as $slot)
                                        <div class="relative w-full" style="height: {{100 / count($slot)}}%">
                                            <p class="absolute top-0 left-0">{{$slot['time']}}</p>

                                            @if(!empty($slot['booking']))
                                                <div class="h-full  pt-8 px-1 mx-1">
                                                    <div class="mx-2 h-full bg-lightBlue rounded-lg p-2">
                                                        <p class="text-sm open-sans">{{$slot['booking'][0]->name}}</p>
                                                        @if($slot['booking'][0]->room)
                                                            <p>Room: {{$slot['booking'][0]->room}}</p>
                                                        @endif
                                                        <p>{{substr($slot['booking'][0]->start_time, 0, -3)}} - {{substr($slot['booking'][0]->end_time, 0, -3)}}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach


                                </div>
                            </div>

                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-hotel-admin-layout>
