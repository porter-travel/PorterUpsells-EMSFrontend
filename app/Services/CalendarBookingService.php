<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarBookingService{
    public function getCalendarBookings($hotel, $request, $get_blocked_slots = true)
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
        return $hotel->calendarBookings()
            ->with(['product', 'variation'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('date', '<=', $startDate)
                            ->where('date', '>=', $endDate);
                    });
            })

            //if $get_blocked_slots is false then exclude records where "name" is "__block__"
            ->when(!$get_blocked_slots, function ($query) {
                $query->where('name', '!=', '__block__');
            })



            ->get();
    }

    public function processBookingsIntoGroups($bookings)
    {
        // Group child bookings by parent_booking_id
        $parentChildGroups = [];
        foreach ($bookings as $key => $booking) {
            if ($booking['parent_booking_id'] !== null) {
                $parentChildGroups[$booking['parent_booking_id']][] = $booking;
//                unset($bookings[$key]); // Remove child bookings
            }
        }

        // Update parent bookings with the latest end_time and count children
        foreach ($bookings as &$parentBooking) {
            $parentId = $parentBooking['id'];
            if (isset($parentChildGroups[$parentId])) {
                $latestEndTime = $parentBooking['end_time'];
                $childrenCount = 0;

                foreach ($parentChildGroups[$parentId] as $childBooking) {
                    $childrenCount++;
                    if ($childBooking['end_time'] > $latestEndTime) {
                        $latestEndTime = $childBooking['end_time'];
                    }
                }

                $parentBooking['end_time'] = $latestEndTime;
                $parentBooking['bookings_count'] = $childrenCount + 1; // Include the parent in the count
            } else {
                $parentBooking['bookings_count'] = 1; // No children, count only the parent
            }
        }

        // Reindex the array and return
        return array_values($bookings);
    }
}
