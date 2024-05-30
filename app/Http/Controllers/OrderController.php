<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function listOrdersByHotel($hotel_id)
    {

        $hotel = Hotel::find($hotel_id);
// Fetch orders with future departure date and their items
        $orders = Order::where('hotel_id', $hotel_id)
            ->with('items')
            ->paginate(10);


        return view('admin.orders.list', ['orders' => $orders, 'hotel' => $hotel]);
    }


    function listOrderItemsForPicking($hotel_id)
    {

        $hotel = Hotel::find($hotel_id);


// Assuming you have the hotel ID

// Fetch orders with future departure date and their items, ordered by soonest item date
        $orders = Order::where('hotel_id', $hotel_id)
            ->where('departure_date', '>', Carbon::now())
            ->where('departure_date', '<=', Carbon::now()->addDays(7))
            ->whereHas('items', function($query) {
                $query->where('date', '>', Carbon::now());
            })
            ->with(['items' => function($query) {
                $query->orderBy('date', 'asc');
            }])
            ->get()
            ->sortBy(function($order) {
                return $order->items->min('date');
            });

// Prepare the result array
        $result = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $result[] = [
                    'order_name' => $order->name,
                    'order_total' => $order->total,
                    'booking_ref' => $order->booking_ref,
                    'item' => $item,
                ];
            }
        }

//        dd($result);

//        dd($result);




        return view('admin.orders.listItemsForPicking', ['orders' => $result, 'hotel' => $hotel]);
    }
}
