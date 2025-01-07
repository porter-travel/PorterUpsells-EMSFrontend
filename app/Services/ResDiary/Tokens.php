<?php

namespace App\Services\ResDiary;

use App\Models\Connection;
use Illuminate\Support\Facades\Http;

class Tokens
{

    public static function refreshAllTokens()
    {
        $tokens = Connection::where('key', 'resdiary_refresh_token')->get();
        foreach ($tokens as $token) {
            $response = Http::asForm()->post(env('RESDIARY_TOKEN_URL'), [
                'client_id' => env('RESDIARY_CLIENT_ID'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $token->value,
                'client_secret' => env('RESDIARY_CLIENT_SECRET'),
            ]);
            $token->value = $response->json()['refresh_token'];
            $token->save();

            $access_token = Connection::where('hotel_id', $token->hotel_id)->where('key', 'resdiary_access_token')->first();
            $access_token->value = $response->json()['access_token'];
            $access_token->save();
        }
    }

    public function refresh()
    {
        // Refresh the tokens
    }
}
