<?php

namespace App\Http\Controllers;

use App\Mail\ConfigTest;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\WelcomeController;

class HotelController extends Controller
{

    public function welcome(Request $request, $id)
    {
        if (is_numeric($id)) {
            $hotel = Hotel::find($id);
        } else {
            $hotel = Hotel::where('slug', $id)->first();
        }

        $name = $request->input('name', '');
        $booking_ref = $request->input('booking_ref', '');
        $arrival_date = $request->input('arrival_date', '');
        $departure_date = $request->input('departure_date', '');
        $email_address = $request->input('email_address', '');

        // Check if all required pieces of information are present
        if ($name && $arrival_date && $departure_date && $email_address) {
            // Create a new request with the needed data
            $newRequest = $request->duplicate([
                'hotel_id' => $hotel->id ?? null,
                'hotel_slug' => $hotel->slug ?? null,
                'name' => $name,
                'booking_ref' => $booking_ref,
                'arrival_date' => $arrival_date,
                'departure_date' => $departure_date,
                'email_address' => $email_address,
            ]);

            // Call the createSession method from AnotherController
            return app(WelcomeController::class)->createSession($newRequest);
        }

        return view('hotel.welcome')->with([
            'hotel' => $hotel,
            'name' => $name,
            'booking_ref' => $booking_ref,
            'arrival_date' => $arrival_date,
            'email_address' => $email_address,
            'departure_date' => $departure_date
        ]);
    }



    function dashboard(Request $request, $id)
    {

//        Mail::to('alex@gluestudio.co.uk')->send(new ConfigTest(json_encode([])));

        $data['name'] = $request->session()->get('name');
        $data['booking_ref'] = $request->session()->get('booking_ref');
        $data['arrival_date'] = $request->session()->get('arrival_date');

        $cart = session()->get('cart');

        if (is_numeric($id)) {
            $hotel = Hotel::find($id);
        } else {
            $hotel = Hotel::where('slug', $id)->first();
        }

        $products = $hotel->products;

        $data['days_until_arrival'] = (strtotime($data['arrival_date']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);

        $data['dummy_items'] = [
            ['img' => 'breakfast.png', 'title' => 'Breakfast', 'price' => '£15.00', 'id' => '1'],
            ['img' => 'prosecco.png', 'title' => 'Bottle of Prosecco in your room', 'price' => '£21.99', 'id' => '1'],
            ['img' => 'romance.png', 'title' => 'Romance package including petals and wine', 'price' => '£49.99', 'id' => '1'],
            ['img' => 'massage.png', 'title' => 'Head massage in our spa facilities', 'price' => '£59.99', 'id' => '1']
        ];

        return view('hotel.dashboard', ['data' => $data, 'hotel' => $hotel, 'products' => $products, 'cart' => $cart])->with('id', $id);
    }

    function create(Request $request)
    {
        return view('admin.hotel.create');
    }

    function store(Request $request)
    {
        $hotel = new \App\Models\Hotel();

        $hotel->name = $request->name;
        $hotel->address = $request->address;
        $hotel->user_id = auth()->user()->id;


        if ($request->file('logo')) {
            $logoFilePath = $request->file('logo')->store('hotel-logos', 's3');

            $url = Storage::disk('s3')->url($logoFilePath);
            $hotel->logo = $url;
        }

        if ($request->file('featured_image')) {
            $featuredImageFilePath = $request->file('featured_image')->store('hotel-featured-images', 's3');
            $featuredImageUrl = Storage::disk('s3')->url($featuredImageFilePath);
            $hotel->featured_image = $featuredImageUrl;
        }

        $hotel->save();
        return redirect()->route('hotel.edit', ['id' => $hotel->id]);
    }

    public function edit(Request $request, $id)
    {
        $hotel = \App\Models\Hotel::find($id);
        if ($hotel->user_id != auth()->user()->id) {
            return redirect()->route('dashboard');
        }
        return view('admin.hotel.edit', ['hotel' => $hotel]);
    }

    public function update(Request $request, $id)
    {
        $hotel = \App\Models\Hotel::find($id);

        if ($request->name) {
            $hotel->name = $request->name;
        }

        if ($request->address) {
            $hotel->address = $request->address;
        }

        if ($request->email_address) {
            $hotel->email_address = $request->email_address;
        }

        if ($request->id_for_integration) {
            $hotel->id_for_integration = $request->id_for_integration;
        }

        if ($request->page_background_color) {
            $hotel->page_background_color = $request->page_background_color;
        }

        if ($request->main_box_color) {
            $hotel->main_box_color = $request->main_box_color;
        }

        if ($request->main_box_text_color) {
            $hotel->main_box_text_color = $request->main_box_text_color;
        }

        if ($request->button_color) {
            $hotel->button_color = $request->button_color;
        }

        if ($request->accent_color) {
            $hotel->accent_color = $request->accent_color;
        }

        if ($request->text_color) {
            $hotel->text_color = $request->text_color;
        }

        if ($request->button_text_color) {
            $hotel->button_text_color = $request->button_text_color;
        }

        if ($request->file('logo')) {
            $filePath = $request->file('logo')->store('hotel-logos', 's3');
            $url = Storage::disk('s3')->url($filePath);
            $hotel->logo = $url;
        }

        if ($request->file('featured_image')) {
            $filePath = $request->file('featured_image')->store('hotel-logos', 's3');
            $url = Storage::disk('s3')->url($filePath);
            $hotel->featured_image = $url;
        }

        $hotel->save();
        return redirect()->route('hotel.edit', ['id' => $hotel->id]);
    }
}
