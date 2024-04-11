<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
class OrderController extends Controller
{
    function listOrdersByHotel($hotel_id)
    {
        $today = Carbon::now()->toDateString();

        $hotel = Hotel::find($hotel_id);
        $orders = Order::where('hotel_id', $hotel_id)
            ->whereDate('arrival_date', '>=', $today)
            ->orderBy('arrival_date')
            ->get();




        return view('admin.orders.list', ['orders' => $orders, 'hotel' => $hotel]);
    }
}
