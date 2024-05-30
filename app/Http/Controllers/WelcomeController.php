<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function createSession(Request $request){

        $hotel_id = $request->input('hotel_id');

        $request->session()->put('name', $request->input('name'));
        $request->session()->put('booking_ref', $request->input('booking_ref'));
        $request->session()->put('arrival_date', $request->input('arrival_date'));
        $request->session()->put('departure_date', $request->input('departure_date'));
        $request->session()->put('email_address', $request->input('email_address'));
        $request->session()->put('hotel_id', $hotel_id);

        return redirect()->route('hotel.dashboard', ['id' => $hotel_id] );
    }
}
