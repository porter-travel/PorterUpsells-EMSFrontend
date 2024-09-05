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
                }, 'items.product', 'items.product.specifics', 'booking'])
                ->get()
                ->sortBy(function ($order) {
                    return $order->items->min('date');
                })->toArray();
        }

//        dd($hotels);
        $output = [];
        foreach ($hotels as $k => $hotel) {
            $output[$k] = [
                'name' => $hotel['name'],
                'logo' => $hotel['logo'],
                'integration' => (bool) $hotel['id_for_integration'],
                'orders' => []
            ];

            foreach ($hotel['orders'] as $hotelOrderKey => $order) {

                $orderArr = [
                    'id' => $order['id'],
                    'name' => $order['booking']['name'],
                    'room' => $order['booking']['room'],
                    'checkin' => $order['booking']['checkin'],
                    'items' => [],
                    'after_checkin' => false
                ];
                foreach ($order['items'] as $item) {
                    $orderArr['items'][] = [
                        'name' => $item['product']['name'],
                        'quantity' => $item['quantity'],
                        'image' => $item['product']['image'],
                    ];

                    foreach ($item['product']['specifics'] as $specific) {
                        if ($specific['name'] == 'after_checkin' && $specific['value'] == "1") {
                            $orderArr['after_checkin'] = true;
                            break;
                        }
                    }
                }


                if ($order['status'] == 'complete') {
                    $output[$k]['orders']['complete'][] = $orderArr;
                } else if ($order['status'] == 'pending' && $orderArr['after_checkin'] && $orderArr['checkin'] == null) {
                    $output[$k]['orders']['pending'][] = $orderArr;
                } else {
                    $output[$k]['orders']['ready'][] = $orderArr;
                }
            }
        }

//        dd($output);


        if (!$fulfilmentKey) {
            return response()->json(['message' => 'Invalid key'], 404);
        }
        if ($fulfilmentKey->expires_at && $fulfilmentKey->expires_at < now()) {
            return response()->json(['message' => 'Key has expired'], 404);
        }

//        dd($hotels);
        return view('admin.fulfilment', ['hotels' => $output, 'key' => $key]);
    }

    public function fulfilOrder(Request $request){
        $key = $request->key;
        $key = FulfilmentKey::where('key', $key)->first();
        if(!$key){
            return response()->json(['message' => 'Invalid key'], 404);
        }

        $order = Order::find($request->orderId);
        if(!$order){
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->status;

        $order->items()->update(['status' => $request->status]);

        $order->save();

    }
}
