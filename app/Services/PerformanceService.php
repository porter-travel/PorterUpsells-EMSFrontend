<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\{CartAnalytics, EmailAnalytics, HotelAnalytics, Order, ProductViews};

class PerformanceService
{
    public function getAnalytics($hotelIds, $startDate, $endDate)
    {
        return [
            'productViews' => ProductViews::whereIn('hotel_id', $hotelIds)
                ->whereBetween('view_date', [$startDate, $endDate])
                ->pluck('views', 'product_id'),

            'hotelAnalytics' => HotelAnalytics::whereIn('hotel_id', $hotelIds)
                ->whereBetween('view_date', [$startDate, $endDate])
                ->select('dashboard_views', 'cart_views')
                ->get(),

            'orders' => Order::whereIn('hotel_id', $hotelIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get(),

            'cartAnalytics' => CartAnalytics::whereIn('hotel_id', $hotelIds)
                ->whereBetween('view_date', [$startDate, $endDate])
                ->get(),

            'emailCount' => EmailAnalytics::whereIn('hotel_id', $hotelIds)
                ->whereBetween('sent_date', [$startDate, $endDate])
                ->sum('email_count'),

            'hotelOrders' => Order::whereIn('hotel_id', $hotelIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('hotel_id, COUNT(*) as total_orders, SUM(subtotal) as total_value')
                ->groupBy('hotel_id')
                ->with('hotel:id,name') // Fetch hotel name alongside the orders
                ->get()
                ->map(function ($order) {
                    return [
                        'hotel_id' => $order->hotel->id,
                        'hotel_name' => $order->hotel->name,
                        'total_orders' => $order->total_orders,
                        'total_value' => $order->total_value,
                    ];
                })
                ->sortByDesc('total_value') // Sort by total_value in descending order
                ->values(), // Reset collection keys for proper indexing
            'productAnalytics' => \DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id') // Join order_items with orders
                ->join('products', 'order_items.product_id', '=', 'products.id') // Join order_items with products
                ->whereIn('orders.hotel_id', $hotelIds) // Filter by the provided hotel IDs
                ->whereBetween('orders.created_at', [$startDate, $endDate]) // Filter by the date range
                ->select(
                    'products.name as product_name', // Select product name
                    \DB::raw('SUM(order_items.quantity) as quantity'), // Sum the quantities for each product
                    \DB::raw('SUM(order_items.quantity * order_items.price) as price') // Sum the total price
                )
                ->groupBy('products.name') // Group by product name to aggregate
                ->get()
                ->sortByDesc('price') // Sort by price in descending order
                ->map(function ($item) {
                    return [
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'total_value' => number_format($item->price, 2), // Format the price
                    ];
                })
//                ->sortByDesc('total_value') // Sort by total_value in descending order
                ->values(), // Reset collection keys for proper indexing
            'customerAnalytics' => Order::whereIn('hotel_id', $hotelIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('email')
                ->selectRaw('email, COUNT(*) as total_orders, SUM(subtotal) as total_value')
                ->get()
        ];
    }


}
