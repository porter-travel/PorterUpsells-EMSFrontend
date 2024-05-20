<?php

namespace App\Http\Controllers;

use App\Mail\ConfigTest;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use \Stripe\Stripe;

use App\Helpers\Money;

class CheckoutController extends Controller
{
    public function initiateCheckout($hotel_id)
    {

        $cart = session()->get('cart');

        $name = session()->get('name');
        $arrival_date = session()->get('arrival_date');
        $email_address = session()->get('email_address');

        $order = new Order();

        $order->hotel_id = $hotel_id;
        $order->items = json_encode($cart);
        $order->name = $name;
        $order->email = $email_address;
        $order->arrival_date = $arrival_date;
        $order->payment_status = 'pending';
        $order->subtotal = $cart['total'];
        $order->total_tax = $cart['tax'];
        $order->total = $cart['total_with_tax'];

        $order->save();

        $items = [];
//        dd($cart);
        foreach ($cart as $item) {
            if (is_array($item)) {
                $items[] = [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $item['product_name'],
                            'description' => $item['name'],
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
            'customer_email' => $email_address,
            'mode' => 'payment',
            'metadata' => [
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
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($e)));
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($e)));
            http_response_code(400);
            exit();
        }

        error_log("Passed signature verification!");
        http_response_code(200);

        if ($event->type == 'checkout.session.completed') {
            $session = \Stripe\Checkout\Session::retrieve([
                'id' => $event->data->object->id,
                'expand' => ['line_items'],
            ]);

            Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($session)));
            $line_items = $session->line_items;


            $order = Order::find($session->metadata->order_id);

            $order->stripe_id = $session->id;
            $order->payment_status = $session->payment_status;

            $order->save();

            Mail::to($session->customer_details->email, $session->metadata->name)->send(new OrderConfirmation($order));

            session()->forget('cart');

            return response()->json(['success' => 'Order created successfully']);


        }


    }

    public function checkoutComplete()
    {

        $cartItems = session()->get('cart');
//        session()->forget('cart');
//dd($cartItems);
//        Mail::to('alex@gluestudio.co.uk', 'Alex')->send(new ConfigTest(json_encode($payload)));
        return view('checkout.complete', ['cartItems' => $cartItems]);

    }

    public function checkoutCancelled()
    {
        return view('checkout.cancelled');
    }
}
