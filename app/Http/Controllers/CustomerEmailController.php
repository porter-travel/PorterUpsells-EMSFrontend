<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEmail;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CustomerEmailController extends Controller
{
    public function compose($id)
    {
        $hotel = Hotel::find($id);
        return view('admin.email.compose', ['hotel' => $hotel]);
    }

    public function send(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        $guest_name = $request->guest_name;
        $arrival_date = $request->arrival_date;
        $departure_date = $request->departure_date;
        $email_address = $request->email_address;
        $booking_ref = $request->booking_ref;

        $content = compact('guest_name', 'arrival_date', 'departure_date', 'booking_ref', 'email_address');


        // Send email
        Mail::to($email_address)->send(new CustomerEmail($hotel, $content));

        return redirect()->back()->with('success', 'Email sent successfully');
    }

    public function cancelScheduledEmails($order)
    {

        $booking = null;

        if ($order->booking_ref)
            $booking = Booking::where('booking_ref', $order->booking_ref)->first();

        if (!$booking)
            $booking = Booking::where('arrival_date', $order->arrival_date)->first();

        if (!$booking)
            $booking = Booking::where('departure_date', $order->departure_date)->first();

        if (!$booking)
            $booking = Booking::where('email_address', $order->email)->first();

        if(!$booking)
            return;

        $unsentEmails = $booking->unsentCustomerEmails();

        foreach ($unsentEmails as $email) {
            $email->delete();
        }
    }
}
