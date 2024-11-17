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

        return $this->generateOrderArrayForEmailAndAdminView($hotel_id, $startDate, $endDate);
    }

    public function generateOrderArrayForEmailAndAdminView($hotel_id, $startDate, $endDate){
        $orders = Order::where('hotel_id', $hotel_id)
            ->where('status', '!=', 'pending') // Exclude orders with status "pending"
            ->whereHas('items', function ($query) use ($startDate, $endDate) {
                $query->whereDate('date', '>=', $startDate->toDateString())
                    ->whereDate('date', '<=', $endDate->toDateString());
            })
            ->with(['items' => function ($query) {
                $query->orderBy('date', 'asc');
            }, 'items.product', 'items.product.specifics', 'booking'])
            ->get()
            ->sortBy(function ($order) {
                return $order->items->min('date');
            });

        // Prepare the result array
        $output = [];
        foreach ($orders as $hotelOrderKey => $order) {

            $orderArr = [
                'id' => $order['id'],
                'room' => $order['booking']['room'],
                'name' => $order['booking']['name'],
                'arrival_date' => $order['booking']['arrival_date'],
                'booking_ref' => $order['booking']['booking_ref'],
                'items' => [],
                'status' => $order['status'],
            ];
            foreach ($order['items'] as $item) {
                $orderArr['items'][] = [
                    'name' => $item['product']['name'],
                    'variation_name' => $item['variation_name'],
                    'quantity' => $item['quantity'],
                    'image' => $item['product']['image'],
                    'date' => $item['date'],
                    'product_type' => $item['product_type'],
                ];

            }

            $output[] = $orderArr;

        }

        return $output;
    }
}
