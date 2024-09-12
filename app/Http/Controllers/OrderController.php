<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function listOrdersByHotel($hotel_id)
    {

        $hotel = Hotel::find($hotel_id);
        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin'){
            return redirect()->route('dashboard');
        }
// Fetch orders with future departure date and their items
        $orders = Order::where('hotel_id', $hotel_id)
            ->with('items')
            ->paginate(10);


        return view('admin.orders.list', ['orders' => $orders, 'hotel' => $hotel]);
    }


    function listOrderItemsForPicking($hotel_id, Request $request)
    {

        $hotel = Hotel::find($hotel_id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin'){
            return redirect()->route('dashboard');
        }

//        global $startDate, $endDate;
        $startDate = Carbon::now()->startOfDay();

        $endDate = Carbon::now()->addDays(7)->endOfDay();

        if($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        }

        $service = new OrderService();

        $output = $service->generateOrderArrayForEmailAndAdminView($hotel_id, $startDate, $endDate);


        return view('admin.orders.listItemsForPicking',
            [
                'orders' => $output,
                'hotel' => $hotel,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ]);
    }

    public function updateOrder(Request $request){
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->items()->update(['status' => $request->status]);

        $order->save();


        if($order->status == 'complete') {
            // Send email to customer later
            $className = 'bg-mint';
        }

        if($order->status == 'cancelled') {
            // Send email to customer later
            $className = 'bg-red';
        }

        if($order->status == 'pending') {
            $className = 'bg-pink';
        }

        return response()->json(['message' => 'Order status updated successfully', 'className' => 'p-2 ' . $className]);

    }

}
