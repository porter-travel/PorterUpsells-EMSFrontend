<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelEmail;
use App\Models\HotelMeta;
use App\Models\Product;
use Illuminate\Http\Request;

class HotelEmailController extends Controller
{
    public function show($id)
    {
        $hotel = Hotel::find($id);
        $user = auth()->user();

        $email_schedule = HotelMeta::where('hotel_id', $hotel->id)->where('key', 'like', 'email-schedule%')->get();
        $email_content = HotelEmail::where('hotel_id', $hotel->id)->first();
        $email_recipients = HotelMeta::where('hotel_id', $hotel->id)->where('key', 'email-recipients')->first()->value ?? '';



        if (!empty($email_schedule)) {
            $email_schedule = array_combine(
                array_column($email_schedule->toArray(), 'key'),
                array_column($email_schedule->toArray(), 'value')
            );
        }

        if($email_content){
            $email_content->featured_products = json_decode($email_content->featured_products);
            $tmp = [];
            foreach ($email_content->featured_products as $key => $product_id) {
                $tmp[] = Product::find($product_id);
            }
            $email_content->featured_products = $tmp;
        } else {
            HotelEmail::createStandardTemplates($hotel->id);
            $email_content = HotelEmail::where('hotel_id', $hotel->id)->first();
            $email_content->featured_products = json_decode($email_content->featured_products);

        }
        if ($user->role === 'superadmin' || $hotel->user_id === $user->id) {
            return view('admin.emails.customise', [
                'hotel' => $hotel,
                'email_schedule' => $email_schedule,
                'email_content' => $email_content,
                'email_recipients' => $email_recipients
            ]);
        } else {
            return redirect()->route('dashboard');
        }

    }

    public function storeCustomisations($hotel_id, Request $request)
    {
        $user = auth()->user();
        $hotel = Hotel::find($hotel_id);
        if ($user->role === 'superadmin' || $hotel->user_id === $user->id) {


            if ($request->has('hotel_meta')) {
                foreach ($request->hotel_meta as $key => $value) {
                    $hotel_meta = HotelMeta::where('hotel_id', $hotel_id)->where('key', $key)->first();
                    if (!$hotel_meta) {
                        $hotel_meta = new HotelMeta();
                        $hotel_meta->hotel_id = $hotel_id;
                        $hotel_meta->key = $key;
                    }
                    if ($value || $value === '0') {
                        $hotel_meta->value = $value;
                        $hotel_meta->save();
                    }
                }
            }

            if($request->has('hotel_email')){
                $hotel_email = HotelEmail::where('hotel_id', $hotel_id)->where('email_type', $request->hotel_email['email_type'])->first();
                if(!$hotel_email){
                    $hotel_email = new HotelEmail();
                    $hotel_email->hotel_id = $hotel_id;
                    $hotel_email->email_type = $request->hotel_email['email_type'];
                }

                $hotel_email->key_message = $request->hotel_email['key-message'];
                $hotel_email->button_text = $request->hotel_email['button-text'];
                $hotel_email->featured_products = json_encode($request->hotel_email['featured-products']);
                $hotel_email->additional_information = $request->hotel_email['additional-information'];
                $hotel_email->save();

            }

            return redirect()->route('email.customise', ['id' => $hotel_id]);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
