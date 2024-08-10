<div class="fulfilment-panel  rounded-xl border border-black mb-4 p-2
@if($status == 'complete')
bg-[#F0F0F0]
text-[#6A6A6A]
@elseif($status == 'pending')
opacity-35
@endif
">
    <div class="flex justify-between items-center">
        <div>
            <form method="post" action="">
                @csrf
                <input data-action="fulfilOrder" data-key="{{$key}}" id="order{{$order['id']}}" type="checkbox" @if($status == 'complete') checked
                       @elseif($status == 'pending') disabled @endif class="mr-2">
                <label for="order{{$order['id']}}">
                    <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M19.6316 0.344169C20.1228 0.803061 20.1228 1.54707 19.6316 2.00596L6.79245 14L0.368419 7.99881C-0.122806 7.53991 -0.122806 6.7959 0.368419 6.33701C0.859645 5.87812 1.65608 5.87812 2.1473 6.33701L6.79245 10.6764L17.8527 0.344169C18.3439 -0.114723 19.1404 -0.114723 19.6316 0.344169Z"
                              fill="#6A6A6A"/>
                    </svg>
                </label>
            </form>
        </div>
        <div>
            <div>
                <span class="mr-2">Guest: </span>
                <span class="text-lg">{{$order['name']}}</span>
            </div>
            <div class="flex items-start justify-start">
                <span class="mr-2">Order:</span>
                    <div>
                @foreach($order['items'] as $item)
                    <div>
                        <span class="text-sm text-gray-600">{{$item['quantity']}} x {{$item['name']}} </span>
                    </div>
                @endforeach
                    </div>
            </div>
        </div>

        <div>
            <div>
                <span class="mr-2">Room:</span>
                <span class="text-lg font-bold">{{$order['room']}}</span>
            </div>
            <div class="bg-[#DDE1DD] p-1 rounded-lg leading-none">
                <span
                    class="text-xs leading-none h-[0.5rem]">Status: {{$order['checkin'] ? 'Checked In' : 'Not arrived'}}</span>
            </div>
        </div>
    </div>
</div>
