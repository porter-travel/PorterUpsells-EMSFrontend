<?php

namespace App\Http\Controllers;

use App\Models\FulfilmentKey;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FulfilmentController extends Controller
{
    public function fulfilment($key)
    {
        $fulfilmentKeys = FulfilmentKey::with('hotel')->where('key', $key)->get();
        $fulfilmentKey = $fulfilmentKeys->first();

        $hotels = [];

        foreach ($fulfilmentKeys as $fulfilmentKey) {
            $hotels[] = $fulfilmentKey->hotel->toArray();
        }

        foreach ($hotels as $k => $hotel) {
//            $hotels[$k]['orders'] = 'styff';
            $hotels[$k]['orders'] = Order::where('hotel_id', $hotel['id'])
                ->whereHas('items', function ($query) {
                    $query->whereDate('date', '=', Carbon::now()->toDateString('Y-m-d'));
                })
                ->with(['items' => function ($query) {
                    $query->orderBy('date', 'asc');
                }])
                ->with('booking')
                ->get()
                ->sortBy(function ($order) {
                    return $order->items->min('date');
                })->toArray();
        }

        dd($hotels);





        if(!$fulfilmentKey){
            return response()->json(['message' => 'Invalid key'], 404);
        }
        if($fulfilmentKey->expires_at && $fulfilmentKey->expires_at < now()){
            return response()->json(['message' => 'Key has expired'], 404);
        }

//        dd($hotels);
        return view('admin.fulfilment', ['hotels' => $hotels]);
    }
}
