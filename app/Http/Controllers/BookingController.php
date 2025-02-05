<?php

namespace App\Http\Controllers;

use App\Jobs\TrackEmailSends;
use App\Models\Booking;
use App\Models\CustomerEmail;
use App\Models\Hotel;
use App\Services\CustomerEmailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Customer;

class BookingController extends Controller
{
    public function create($id)
    {
        $hotel = Hotel::find($id);

        return view('admin.booking.create', ['hotel' => $hotel]);
    }

    public function store(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        $content = $request->only(['guest_name', 'arrival_date', 'departure_date', 'email_address', 'booking_ref']);

        dd($content);
        $booking = Booking::create([
            'hotel_id' => $id,
            'name' => $content['guest_name'],
            'email_address' => $content['email_address'],
            'arrival_date' => $content['arrival_date'],
            'departure_date' => $content['departure_date'],
            'booking_ref' => $content['booking_ref'],
        ]);

        if ($request->has('send_email')) {
            $customerEmailService = new CustomerEmailService();
            $customerEmailService->setupEmailSchedule([
                'days' => $request->send_email,
                'booking' => $booking,
                'arrival_date' => $content['arrival_date'],
                'email_address' => $content['email_address'],
                'hotel' => $hotel,
                'content' => $content,
            ]);
        }

        return to_route('bookings.list', ['id' => $id]);

    }


    public function list(Request $request, $id)
    {


        // Fetch the hotel by ID
        $hotel = Hotel::find($id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }

        // Ensure the hotel is found
        if (!$hotel) {
            return redirect()->back()->with('error', 'Hotel not found');
        }

        $bookings = $this->getListOfOrders($hotel, $request);


        return view('admin.booking.list', [
            'bookings' => $bookings,
            'hotel' => $hotel,
            'startDate' => $request->input('start_date', Carbon::now()->format('Y-m-d')),
            'endDate' => $request->input('end_date', Carbon::now()->addDays(7)->format('Y-m-d')),
        ]);
    }

    public function exportGuestsToCSV($id, Request $request)
    {

        // Fetch the hotel by ID
        $hotel = Hotel::find($id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }

        // Ensure the hotel is found
        if (!$hotel) {
            return redirect()->back()->with('error', 'Hotel not found');
        }

        $bookings = $this->getListOfOrders($hotel, $request);

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=guests.csv",
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Booking Ref', 'Room', 'Stay Dates', 'Name', 'Email Address']);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_ref,
                    $booking->room,
                    \App\Helpers\Date::formatToDayAndMonth($booking->arrival_date) . ' - ' . \App\Helpers\Date::formatToDayAndMonth($booking->departure_date),
                    $booking->name,
                    $booking->email_address,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

    public function updateBooking($booking_id, Request $request)
    {
        $booking = Booking::find($booking_id);

        if ($request->has('room')) {
            $booking->room = $request->room;
        }

        $booking->save();

        return response()->json(['message' => 'Booking updated successfully']);
    }

    public function fetchBookingsByDate($hotel_id, Request $request)
    {
        $hotel = Hotel::find($hotel_id);

        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $date = Carbon::createFromFormat('Y-m-d', $request->date);

        $bookings = $hotel->bookings()
            ->where('arrival_date', '<=', $date)
            ->where('departure_date', '>=', $date)
            ->select(['name', 'room'])->get();

        return response()->json($bookings);
    }

    private function getListOfOrders($hotel, $request)
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
