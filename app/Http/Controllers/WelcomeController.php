<?php

namespace App\Http\Controllers;

use App\Mail\ConfigTest;
use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller
{
    public function createSession(Request $request){

        $hotel_id = $request->input('hotel_id');
        $hotel_slug = $request->input('hotel_slug');

        $request->session()->put('name', $request->input('name'));
        $request->session()->put('booking_ref', $request->input('booking_ref'));
        $request->session()->put('arrival_date', $request->input('arrival_date'));
        $request->session()->put('departure_date', $request->input('departure_date'));
        $request->session()->put('email_address', $request->input('email_address'));
        $request->session()->put('hotel_id', $hotel_id);
        $data = $request->session()->all();
//dd($request->session()->all());
        return redirect()->route('hotel.dashboard', ['id' => $hotel_slug, 'data' => $data] );
    }

    public function setUserStayDates(Request $request){
        $request->session()->put('arrival_date', $request->input('arrival_date'));
        $request->session()->put('departure_date', $request->input('departure_date'));
        return redirect()->back();
    }

    public function submit_form(Request $request)
    {
        // Validate the request inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);


        // Prepare the email content
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $request->input('company', ''),
            'message' => $validated['message'],
        ];

        // Send the email
        Mail::to('hi@enhancemystay.com', 'Enhance My Stay')->send(new ContactForm($data));

        // Redirect back with a success message
        return redirect('/contact')->with('success', 'Thank you for your enquiry, we will be in touch soon.');
    }

}
