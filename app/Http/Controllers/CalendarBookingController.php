<?php

namespace App\Http\Controllers;

use App\Helpers\Intervals;
use App\Models\CalendarBooking;
use App\Models\Hotel;
use App\Models\Product;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarBookingController extends Controller
{
    public function list($hotel_id, Request $request)
    {
        $hotel = Hotel::find($hotel_id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }

//        global $startDate, $endDate;
        $startDate = Carbon::now()->startOfDay();

        $endDate = Carbon::now()->addDays(7)->endOfDay();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        }


        $output = CalendarBooking::where('hotel_id', $hotel_id)
            ->whereDate('date', '>=', $startDate->toDateString())
            ->whereDate('date', '<=', $endDate->toDateString())
            ->with(['order', 'order.items', 'order.items.product', 'order.items.meta'])
            ->get();

//dd($output);
        $groupedBookings = [];

        foreach ($output as $booking) {
            $bookingDate = $booking['date'];

            // Ensure the date exists in the grouped array
            if (!isset($groupedBookings[$bookingDate])) {
                $groupedBookings[$bookingDate] = [];
            }

            foreach ($booking['order']['items'] as $item) {
                // Extract meta information
                $meta = [];
                foreach ($item['meta'] as $metaItem) {
                    $meta[$metaItem['key']] = $metaItem['value'];
                }

                // Add the item to the grouped bookings
                $groupedBookings[$bookingDate][$item['id']] = [
                    'name' => $booking['order']['name'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'arrival_time' => $meta['arrival_time'] ?? null,
                    'end_time' => $meta['end_time'] ?? null,
                ];
            }
        }

//        dd($groupedBookings);

        return view('admin.calendar.list',
            [
                'orders' => $groupedBookings,
                'hotel' => $hotel,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ]);
    }

    public function listProductGrid($hotel_id, Request $request)
    {
        $hotel = Hotel::find($hotel_id);

        $products = $hotel->products->where('type', 'calendar');

        return view('admin.calendar.list-product-grid', ['products' => $products, 'hotel' => $hotel]);

    }

    public function listBookingsForProduct($hotel_id, $product_id, Request $request)
    {
        $product = Product::find($product_id);
        $specifics = $product->specifics;
        $interval = $product->specifics->where('name', 'time_intervals')->first()->value;
        $availability = $product->specifics->where('name', 'concurrent_availability')->first()->value;
        $hotel = Hotel::find($hotel_id);
        $date = Carbon::now()->startOfDay();
        if ($request->has('date')) {
            $date = Carbon::createFromFormat('Y-m-d', $request->input('date'));
        }

        $day = strtolower($date->dayName);

        $step = Intervals::wordsToMinutes($interval);
        $startTime = $product->specifics->where('name', "start_time_{$day}")->first()->value;
        $endTime = $product->specifics->where('name', "end_time_{$day}")->first()->value;
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $availableTimes = [];
        // Generate times

        $i = 0;
        while($i < (int)$availability){
            for ($time = $start; $time + $step <= $end; $time += $step) {
                $availableTimes[$i][] = ['time' => date('H:i', $time)];
            }
            $i++;
        }





        $bookings = CalendarBooking::where('hotel_id', $hotel_id)
            ->where('product_id', $product_id)
            ->whereDate('date', $date->toDateString())
            ->with([])
            ->get();

//        dd($bookings->toArray(), $availableTimes);
        // Initialize a tracking array for remaining quantities
        $bookingQuantities = [];
        foreach ($bookings as $index => $booking) {
            $bookingQuantities[$index] = $booking['qty'];
        }

        foreach ($availableTimes as $dayIndex => &$dayTimes) {
            foreach ($dayTimes as &$timeSlot) {
                $timeSlot['booking'] = []; // Initialize booking key

                foreach ($bookings as $bookingIndex => $booking) {
                    if ($booking['start_time'] === $timeSlot['time'] . ":00" && $bookingQuantities[$bookingIndex] > 0) {
                        // Add booking to the current slot
                        $timeSlot['booking'][] = $booking;

                        // Decrement remaining qty
                        $bookingQuantities[$bookingIndex]--;

                        break; // Move to the next time slot
                    }
                }
            }
        }
        unset($dayTimes, $timeSlot); // Break references






        return view('admin.calendar.list-bookings-for-product', [
            'product' => $product,
            'specifics' => $specifics,
            'interval' => $interval,
            'availability' => $availability,
            'availableTimes' => $availableTimes,
            'hotel' => $hotel,
            'bookings' => $bookings,
            'date' => $date->format('Y-m-d')
        ]);
    }
}
