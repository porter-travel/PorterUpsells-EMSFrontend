<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public $hotel;

    public function __construct()
    {
    }

    public function getOrdersByHotelForNextSevenDays($hotel_id)
    {

        $this->hotel = Hotel::find($hotel_id);
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(7)->endOfDay();

        $orders = Order::where('hotel_id', $this->hotel->id)
            ->whereHas('items', function ($query) use ($startDate, $endDate) {
                $query->whereDate('date', '>=', $startDate->toDateString())
                    ->whereDate('date', '<=', $endDate->toDateString());
            })
            ->with(['items' => function ($query) {
                $query->orderBy('date', 'asc');
            }])
            ->get()
            ->sortBy(function ($order) {
                return $order->items->min('date');
            });

        $result = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                // Convert item date string to Carbon instance
                $itemDate = Carbon::createFromFormat('Y-m-d', $item->date);

                // Check if the item date is within the range
                if ($itemDate->between($startDate, $endDate)) {
                    $result[] = [
                        'order_name' => $order->name,
                        'order_total' => $order->total,
                        'booking_ref' => $order->booking_ref,
                        'item' => $item,
                    ];
                }
            }
        }

        return $result;
    }
}
