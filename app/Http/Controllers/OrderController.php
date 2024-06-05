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


    function listOrderItemsForPicking($hotel_id, Request $request)
    {

        $hotel = Hotel::find($hotel_id);

        $startDate = Carbon::now();

        $endDate = Carbon::now()->addDays(7);

        if($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        }



// Assuming you have the hotel ID

// Fetch orders with future departure date and their items, ordered by soonest item date
        $orders = Order::where('hotel_id', $hotel_id)
            ->where('departure_date', '>', $startDate)
            ->where('departure_date', '<=', $endDate)
            ->whereHas('items', function ($query) {
                $query->where('date', '>', Carbon::now());
            })
            ->with(['items' => function ($query) {
                $query->orderBy('date', 'asc');
            }])
            ->get()
            ->sortBy(function ($order) {
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

        return view('admin.orders.listItemsForPicking',
            [
                'orders' => $result,
                'hotel' => $hotel,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ]);
    }
}
