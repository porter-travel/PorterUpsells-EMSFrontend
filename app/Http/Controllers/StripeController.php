<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function create_connected_account(Request $request)
    {

        $user = auth()->user();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $acc = $stripe->accounts->create([
            'country' => $request->country_code,
            'email' => $user->email,
            'controller' => [
                'fees' => ['payer' => 'application'],
                'losses' => ['payments' => 'application'],
                'stripe_dashboard' => ['type' => 'express'],
            ],
        ]);

//        dd($acc);
        $user->country_code = $request->country_code;
        $user->currency = $acc->default_currency;
        $user->stripe_account_number = $acc->id;

        $user->save();


        $url = $this->create_account_link($acc->id);

        return redirect($url);
    }

    public function return_connected_account()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $user = auth()->user();

        $account = $stripe->accounts->retrieve(
            $user->stripe_account_number,
            []
        );
        if ($account->details_submitted) {
            $user->stripe_account_active = true;
            $user->save();
        }

        return view('profile.connected-account-created');


    }

    public function refresh_connected_account()
    {
        $user = auth()->user();
        $url = $this->create_account_link($user->stripe_account_number);

        return redirect($url);
    }

    private function create_account_link($account_id)
    {

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));


        $links = $stripe->accountLinks->create([
            'account' => $account_id,
            'refresh_url' => env('APP_URL') . '/admin/create-connected-account/refresh',
            'return_url' => env('APP_URL') . '/admin/create-connected-account/return',
            'type' => 'account_onboarding',
        ]);

        return $links->url;

    }

}
