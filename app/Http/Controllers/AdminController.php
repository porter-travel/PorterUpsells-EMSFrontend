<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {

        $user = auth()->user();

        $hotels = Hotel::whereBelongsTo($user)->get();
//        dd($hotels);

        if($user->account_status === 'pending'){
            return view('admin.pending-dashboard', ['user' => $user]);
        }
        return view('admin.dashboard', ['hotels' => $hotels]);
    }
}
