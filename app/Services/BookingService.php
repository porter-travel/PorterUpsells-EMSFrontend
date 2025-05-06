<?php

namespace App\Services;
use Carbon\Carbon;

class BookingService {
    public function getListOfOrders($hotel, $request)
    {
        // Import Carbon at the top of the controller if not already done
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        } else {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->addDays(7)->endOfDay();
        }

        // Filter bookings based on the date range
        return $hotel->bookings()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('arrival_date', [$startDate, $endDate])
                    ->orWhereBetween('departure_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('arrival_date', '<=', $startDate)
                            ->where('departure_date', '>=', $endDate);
                    });
            })
            ->get();
    }
}
