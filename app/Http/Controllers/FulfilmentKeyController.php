<?php

namespace App\Http\Controllers;

use App\Models\FulfilmentKey;
use App\Models\Hotel;
use Illuminate\Http\Request;


class FulfilmentKeyController extends Controller
{
    public function list()
    {
        $keys = FulfilmentKey::with('hotel')->where('user_id', auth()->id())->get();
        $groupedKeys = $keys->groupBy('key');

        $result = [];

        foreach ($groupedKeys as $key => $group) {
            $result[$key] = [
                'name' => $group->first()->name,
                'expires_at' => $group->first()->expires_at,
                'hotels' => $group->pluck('hotel')->toArray()
            ];
        }

        return view('admin.fulfilment-keys.list', ['keys' => $result]);
    }

    public function create()
    {
        if(auth()->user()->role == 'superadmin') {
            $hotels = Hotel::all();
        }else {
            // Assuming you have a hotels relationship on the User model (which is a collection of hotels the user has access to
            $hotels = auth()->user()->hotels;
        }


        return view('admin.fulfilment-keys.create',[ 'hotels' => $hotels]);
    }

    public function store(Request $request)
    {

        $keyValue = bin2hex(auth()->id() . time() . random_bytes(8));
        foreach ($request->hotel as $hotel) {

            $key = new FulfilmentKey();
            $key->name = $request->name;
            $key->key = $keyValue;
            $key->hotel_id = $hotel;
            $key->expires_at = $request->expires_at;
            $key->user_id = auth()->id();
            $key->save();
        }

        return redirect()->route('fulfilment-keys.list');
    }


    public function delete($key){

        FulfilmentKey::where('key', $key)->delete();
        return redirect()->route('fulfilment-keys.list');

    }
}
