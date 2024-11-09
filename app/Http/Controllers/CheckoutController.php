<?php

namespace App\Http\Controllers;

use App\Mail\ConfigTest;
use App\Mail\OrderConfirmation;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use \Stripe\Stripe;

use App\Helpers\Money;

class CheckoutController extends Controller
{
    public function initiateCheckout($hotel_id)
    {

        if (is_numeric($hotel_id)) {
            $the_hotel_id = $hotel_id;
        } else {
            $hotel = Hotel::where('slug', $hotel_id)->first();
            $the_hotel_id = $hotel->id;
        }


        $cart = session()->get('cart');


        $name = session()->get('name');
        $arrival_date = session()->get('arrival_date');
        $departure_date = session()->get('departure_date');
        $email_address = session()->get('email_address');
        $booking_ref = session()->get('booking_ref');

        $booking = null;
        if($booking_ref != null) {
            $booking = Booking::where('hotel_id', $the_hotel_id)->where('booking_ref', $booking_ref)->first();
        }

        if (!$booking) {
            $booking = Booking::where('hotel_id', $the_hotel_id)->where('email_address', $email_address)->where('arrival_date', $arrival_date)->first();
        }

        if (!$booking) {
            $booking = Booking::where('hotel_id', $the_hotel_id)->where('email_address', $email_address)->where('departure_date', $departure_date)->first();
        }

        if (!$booking) {
            $booking = new Booking([
                'hotel_id' => $the_hotel_id,
                'name' => $name,
                'email_address' => $email_address,
                'arrival_date' => $arrival_date,
                'departure_date' => $departure_date,
                'booking_ref' => $booking_ref
            ]);
            $booking->save();
        }


        $order = new Order();
        $order->hotel_id = $the_hotel_id;
        $order->booking_id = $booking->id;
        $order->name = $name;
        $order->email = $email_address;
        $order->arrival_date = $arrival_date;
        $order->departure_date = $departure_date;
        $order->payment_status = 'pending';
        $order->subtotal = $cart['total'];
        $order->total_tax = $cart['tax'];
        $order->total = $cart['total_with_tax'];

        $order->save();

        $items = [];
//        dd($cart);
        foreach ($cart as $item) {
            if (is_array($item)) {

                //This is the OrderItem model which we store in the database
                $OrderItem = new OrderItem();

                $OrderItem->order_id = $order->id;
                $OrderItem->product_id = $item['product_id'];
                $OrderItem->variation_id = $item['variation_id'];
                $OrderItem->product_name = $item['product_name'];
                $OrderItem->variation_name = $item['variation_name'];
                $OrderItem->quantity = $item['quantity'];
                $OrderItem->price = $item['price'];
                $OrderItem->image = $item['image'];
                $OrderItem->date = $item['date'];
                $OrderItem->product_type = $item['product_type'];

                $OrderItem->save();


                //This $items array is the one we send to Stripe
                $items[] = [
                    'price_data' => [
                        'currency' => $hotel->user->currency,
                        'product_data' => [
                            'name' => $item['product_name'],
                            'description' => $item['variation_name'],
                            'images' => [$item['image']],

                        ],
                        'unit_amount' => $item['price'] * 100,
                    ],
                    'quantity' => $item['quantity'],
//                    'tax_rates' => ['txr_1P3JhAJQ5u1m2fEs9mBMawIb']
                ];
            }
        }

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET_KEY')
        );

        $checkout_session = $stripe->checkout->sessions->create([
            'success_url' => env('APP_URL') . '/checkout/complete',
            'cancel_url' => env('APP_URL') . '/checkout/cancelled',
            'payment_method_types' => ['card'],
            'line_items' => [
                $items
            ],
            'payment_intent_data' => [
                //Take 0.4% of the order total for the application fee
                'application_fee_amount' => round(($order->total * 0.035) * 100, 0),
                'transfer_data' => ['destination' => $hotel->user->stripe_account_number],
            ],
            'mode' => 'payment',
            'custom_fields' => [
                [
                    'key' => 'name',
                    'label' => [
                        'type' => 'custom',
                        'custom' => 'Name on Booking',
                    ],
                    'type' => 'text',
                ],
            ],
            'metadata' => [
                'payment_type' => 'hotel_item_order',
                'order_id' => $order->id, // This is the order ID from your system
                'name' => $name,
                'arrival_date' => $arrival_date,
                'hotel_id' => $hotel_id
            ]
        ]);

//        header("HTTP/1.1 303 See Other");
//        header("Location: " . $checkout_session->url);

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        return Redirect::to($checkout_session->url);
    }

    public function checkoutSessionWebhook(Request $request)
    {

        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $stripe_secret_key = env('STRIPE_SECRET_KEY');
        \Stripe\Stripe::setApiKey($stripe_secret_key);

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

//        $test = [$endpoint_secret, $stripe_secret_key, $payload, $sig_header];

//        Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($test)));


        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode(['UnexpectedValueException', $e])));
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode(['SignatureVerificationException', $e])));
            http_response_code(400);
            exit();
        } catch (\Exception $e) {

//            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($stripe_secret_key)));
//            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($endpoint_secret)));
            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($e)));
            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($event)));
            http_response_code(400);
            exit();
        }

        error_log("Passed signature verification!");
        http_response_code(200);

        if ($event->type == 'checkout.session.completed') {
            if ($event->data->object->metadata->payment_type === 'hotel_item_order') {
                $session = \Stripe\Checkout\Session::retrieve([
                    'id' => $event->data->object->id,
                    'expand' => ['line_items'],
                ]);

//                Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($event)));
                $line_items = $session->line_items;


                $order = Order::find($session->metadata->order_id);
                try {
                    $order->stripe_id = $session->id;
                    $order->payment_status = $session->payment_status;
                    $order->email = $session->customer_details->email;
                    foreach ($session->custom_fields as $field) {
                        if ($field->key === 'name') {
                            $order->name = $field->text->value;
                            break;
                        }
                    }
                    $order->save();
                } catch (\Exception $e) {
                    Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($e)));
                }

                Mail::to($session->customer_details->email, $session->metadata->name)->send(new OrderConfirmation($order));
//                Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($session)));


                //Cancel any Scheduled Emails for the customer

                $controller = new CustomerEmailController();
                $controller->cancelScheduledEmails($order);

                //Update the booking object
                $booking = Booking::find($order->booking_id);
                $booking->name = $order->name;
                $booking->email_address = $order->email;
                if($booking->arrival_date == null) {
                    $booking->arrival_date = $order->arrival_date;
                }
                if($booking->departure_date == null) {
                    $booking->departure_date = $order->departure_date;
                }
                $booking->save();


                session()->forget('cart');


                return response()->json(['success' => 'Order created successfully']);
            } else {
//                Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($event)));

                $client_reference_id = $event->data->object->client_reference_id;
                //Remove the string 'USER_' from the client_reference_id
                $client_reference_id = substr($client_reference_id, 5);
                $user = User::find($client_reference_id);
                $user->account_status = 'active';
                $user->save();
                return response()->json(['success' => 'User account activated successfully']);

            }


        }


    }

    public function checkoutComplete()
    {

        $hotel_id = session()->get('hotel_id');
        if (is_numeric($hotel_id)) {
            $hotel = Hotel::find($hotel_id);
        } else {
            $hotel = Hotel::where('slug', $hotel_id)->first();
        }
        $cartItems = session()->get('cart');
        session()->forget('cart');
//dd($cartItems);
//        Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($payload)));
        return view('checkout.complete', ['cartItems' => $cartItems, 'hotel' => $hotel]);

    }

    public function checkoutCancelled()
    {
        return view('checkout.cancelled');
    }
}
