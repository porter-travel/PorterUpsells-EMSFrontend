<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($request->id);
        $orderItem->status = $request->status;
        $orderItem->save();

        if ($orderItem->status == 'fulfilled') {
            // Send email to customer later
            $className = 'bg-mint';
        }

        if ($orderItem->status == 'cancelled') {
            // Send email to customer later
            $className = 'bg-red';
        }

        if ($orderItem->status == 'pending') {
            $className = 'bg-pink';
        }

        return response()->json(['message' => 'Order status updated successfully', 'className' => 'order-status-select rounded-full ' . $className]);
    }

    public function listOrdersByHotelv2($hotel_id, Request $request)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }

        $orders = $this->getFilteredOrders($hotel_id, $request)->paginate(10)->appends(request()->query());

        return view('admin.orders.listv2', [
            'orders' => $orders,
            'hotel' => $hotel,
            'startDate' => $request->input('start_date', Carbon::now()->format('Y-m-d')),
            'endDate' => $request->input('end_date', Carbon::now()->addDays(7)->format('Y-m-d')),
            'filterStatus' => $request->input('status', 'all')
        ]);
    }


    public function exportOrdersToCsv($hotel_id, Request $request)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }

        $orders = $this->getFilteredOrders($hotel_id, $request)->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Booking Ref', 'Room', 'Fulfilment Date', 'Name', 'Items', 'Fulfilment Status']);

            foreach ($orders as $order) {
                $items = "{$order->quantity} x {$order->product_name}";

                if ($order->product_type == 'variable') {
                    $items .= " ({$order->variation_name})";
                }

                foreach ($order->meta as $meta) {
                    if ($meta->key == 'arrival_time') {
                        $items .= " | Time: {$meta->value}";
                    }
                }

                fputcsv($file, [
                    $order->order->booking_ref,
                    $order->order->room_number,
                    \App\Helpers\Date::formatToDayAndMonth($order->date),
                    $order->order->name,
                    $items,
                    ucfirst($order->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    private function getFilteredOrders($hotel_id, Request $request)
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(7)->endOfDay();
        $filter = $request->input('status', 'all');

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        }

        return OrderItem::where('hotel_id', $hotel_id)
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->when($filter !== 'all', function ($query) use ($filter) {
                $query->where('status', $filter);
            })
            ->whereHas('order', function ($query) {
                $query->where('payment_status', '!=', 'pending');
            })
            ->with(['order', 'product', 'meta'])
            ->orderBy('date');
    }

}
