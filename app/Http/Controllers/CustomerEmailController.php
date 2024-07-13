<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEmail;
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

        $content = compact( 'guest_name', 'arrival_date', 'departure_date', 'booking_ref', 'email_address');



        // Send email
         Mail::to($email_address)->send(new CustomerEmail($hotel, $content));

        return redirect()->back()->with('success', 'Email sent successfully');
    }

    public function cancelScheduledEmails($order)
    {
        if($order->booking_ref) {
            // First, try to find emails by booking_ref
            $emails = DB::table('customer_emails')
                ->where('booking_ref', $order->booking_ref)
                ->whereNull('sent_at')
                ->get();
        }

        // If no emails found, try to find by arrival_date and email
        if ($emails->isEmpty()) {
            $emails = DB::table('customer_emails')
                ->where('arrival_date', $order->arrival_date)
                ->where('email_address', $order->email)
                ->whereNull('sent_at')
                ->get();
        }

        // If still no emails found, try to find by departure_date and email
        if ($emails->isEmpty()) {
            $emails = DB::table('customer_emails')
                ->where('departure_date', $order->departure_date)
                ->where('email_address', $order->email)
                ->whereNull('sent_at')
                ->get();
        }

        // Delete any found emails
        if (!$emails->isEmpty()) {
            DB::table('customer_emails')
                ->whereIn('id', $emails->pluck('id'))
                ->delete();
        }
    }
}
