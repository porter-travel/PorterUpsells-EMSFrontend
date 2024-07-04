<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CustomerEmail;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Customer;

class BookingController extends Controller
{
    public function create($id){
        $hotel = Hotel::find($id);
        return view('admin.booking.create', ['hotel' => $hotel]);
    }

    public function store(Request $request, $id){
        $hotel = Hotel::find($id);
        $content = $request->only(['guest_name', 'arrival_date', 'departure_date', 'email_address', 'booking_ref']);

        $booking = Booking::create([
            'hotel_id' => $id,
            'name' => $content['guest_name'],
            'email_address' => $content['email_address'],
            'arrival_date' => $content['arrival_date'],
            'departure_date' => $content['departure_date'],
            'booking_ref' => $content['booking_ref'],
        ]);

        if($request->has('send_email')){
            foreach ($request->send_email as $email){
                $customer_email = new CustomerEmail(['booking_id' => $booking->id]);

                if(is_numeric($email)) {
                    $customer_email->email_type = 'pre-arrival';
                    $customer_email->scheduled_at = Carbon::createFromFormat('Y-m-d', $content['arrival_date'])->subDays($email);
                } else {
                    $customer_email->email_type = $email;
                    $customer_email->scheduled_at = Carbon::now();
                    Mail::to($content['email_address'])->send(new \App\Mail\CustomerEmail($hotel, $content));
                    $customer_email->sent_at = Carbon::now();
                }

                $customer_email->save();
            }
        }
    }


    public function list(Request $request, $id){
        $hotel = Hotel::find($id);
        $startDate = Carbon::now()->startOfDay();

        $endDate = Carbon::now()->addDays(7)->endOfDay();
        if($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        }

        $bookings = $hotel->bookings;
        return view('admin.booking.list', ['bookings' => $bookings, 'hotel' => $hotel, 'startDate' => $startDate, 'endDate' => $endDate]);
    }
}
