<?php

namespace App\Services\ResDiary;

use App\Models\Connection;
use App\Models\OrderResdiary;
use Illuminate\Support\Facades\Http;

class ResDiaryBooking
{
    public static function createBooking($accessToken, $resdiary_microsite_name, $cartData, $hotel_id)
    {

        $bookingData = self::formatCartDataToBookingData($cartData);
        $response = Http::withToken($accessToken)
            ->post("https://api.rdbranch.com/api/ConsumerApi/v1/Restaurant/$resdiary_microsite_name/BookingWithStripeToken", $bookingData);

//        dd($response->json());
        if ($response->successful()) {
            $data = $response->json();

            if($data['Status'] == 'NoAvailability'){
                return ['error' => 'No availability'];
            }

//            dd($data);
            $order_resdiary = new OrderResdiary();
            $order_resdiary->hotel_id = $hotel_id;
            $order_resdiary->order_id = null;
            $order_resdiary->resdiary_id = $data['Booking']['Id'];
            $order_resdiary->resdiary_reference = $data['Booking']['Reference'];
            $order_resdiary->visit_date = $bookingData['VisitDate'];
            $order_resdiary->visit_time = $bookingData['VisitTime'];
            $order_resdiary->party_size = $bookingData['PartySize'];
            $order_resdiary->save();
//            dd($data);
            return $data;
            // Process the response data as needed
        } else {
            // Handle errors here
            $error = $response->body();
            dd("error", $error);
        }
    }

    public static function deleteBooking(OrderResdiary $order){
        $microsite_name = Connection::where('hotel_id', $order->hotel_id)->where('key', 'resdiary_microsite_name')->first()->value;
        $response = Http::withToken($order->hotel->resdiary_access_token)
            ->post("https://api.rdbranch.com/api/ConsumerApi/v1/Restaurant/{$microsite_name}/Booking/{$order->resdiary_reference}/Cancel");

        if ($response->successful()) {
            $data = $response->json();
            $order->delete();
            return $data;
            // Process the response data as needed
        } else {
            // Handle errors here
            $error = $response->body();
            dd("error", $error);
        }
    }

    private static function formatCartDataToBookingData($cartData)
    {
        $cartData = [
            'ChannelCode' => 'ENHANCEMYSTAY',
            'VisitDate' => $cartData['date'],
            'PartySize' => $cartData['quantity'],
            'VisitTime' => $cartData['cart_item_meta']['arrival_time'],
            'PromotionId' => $cartData['cart_item_meta']['resdiary_promotion_id'],
            'IsLeaveTimeConfirmed' => true,
            'Customer' => [
                'FirstName' => $cartData['first_name'],
                'Surname' => $cartData['last_name'],
                'Email' => $cartData['email'],
                'Mobile' => $cartData['phone'],
            ]
        ];

        return $cartData;
        // Format the cart data to the required format for the ResDiary API
    }
}
