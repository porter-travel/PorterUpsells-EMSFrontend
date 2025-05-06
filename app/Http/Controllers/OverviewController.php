<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Services\BookingService;
use App\Services\CalendarBookingService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index($id, Request $request)
    {
        $hotel = Hotel::find($id);

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

        $OS = new OrderService();
        $orders = $OS->getFilteredOrders($id, $request)->get();

        $CBS = new CalendarBookingService();
        $bookings = $CBS->getCalendarBookings($hotel, $request, false);
        $bookings = $CBS->processBookingsIntoGroups($bookings->toArray());

//        dd($orders->toArray(), $bookings);
//        dd($bookings->toArray());

//dd($orders->toArray());

        $mergedByDate = [];

// Merge both arrays into one
        $allItems = array_merge($orders->toArray(), $bookings);

        foreach ($allItems as $item) {
            $date = $item['date'];

            if (!isset($mergedByDate[$date])) {
                $mergedByDate[$date] = [];
            }

            $mergedByDate[$date][] = $item;
        }

//        dd($mergedByDate);

        return view('admin.overview.index', [
            'items' => $mergedByDate,
            'orders' => $orders,
            'hotel' => $hotel,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'filterStatus' => $request->input('status', 'all')

        ]);
    }
}
