<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\ResDiary\Availability;

class ResDiaryController extends Controller
{

    public $is_test = false;

    public function __construct($is_test = false){
        $this->is_test = $is_test;
    }
    public function install(Request $request)
    {
        // Generate the code verifier and challenge
        $codeVerifier = $this->generateCodeVerifier();
        session()->put('code_verifier', $codeVerifier);  // Store codeVerifier in session properly
        $codeChallenge = $this->generateCodeChallenge($codeVerifier);
        session()->put('code_challenge', $codeChallenge);  // Store codeChallenge in session properly

        // Get all query parameters
        $data = $request->query();

        // Parse the authorization_uri separately if it contains more query parameters
        if (isset($data['authorization_uri'])) {
            // Ensure there's no duplicate response_type by removing it if it already exists
            $authorizationUri = parse_url($data['authorization_uri'], PHP_URL_QUERY);
            parse_str($authorizationUri, $authParams);

            // Remove any duplicate 'response_type'
            unset($authParams['response_type']);
        }

        // Add response_type=code only once
        $authorizationUrl = $data['authorization_uri']
            . '&code_challenge=' . $codeChallenge
            . '&code_challenge_method=S256';
//dd($authorizationUrl);
        // Redirect to the authorization URL
        return redirect($authorizationUrl);
    }


    public function callback(Request $request)
    {

        $codeVerifier = session()->get('code_verifier');
        if (!$codeVerifier) {
            dd('Code verifier is missing');
        }

        $codeChallenge = session()->get('code_challenge');
        if (!$codeChallenge) {
            dd('Code challenge is missing');
        }

        $code = $request->code;
        if (!$code) {
            dd('Code is missing');
        }


        $response = Http::asForm()->post(env('RESDIARY_TOKEN_URL'), [
            'client_id' => env('RESDIARY_CLIENT_ID'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_secret' => env('RESDIARY_CLIENT_SECRET'),
            'redirect_uri' => env('APP_URL') . '/resdiary/callback',
//            'redirect_uri' => 'https://z5ypodmyns.sharedwithexpose.com/resdiary/callback',
            'code_verifier' => $codeVerifier,
//            'response_type' => 'code',
//            'code_challenge' => $codeChallenge,
        ]);

        if ($response->failed()) {
            dd('ERROR AT THE CALLBACK', $response->body()); // Log or display the error for debugging
        }

        $user = auth()->user();
        $hotels = $user->hotels;
        if ($hotels->count() == 0) {
            $status = 'error';
        } elseif ($hotels->count() > 1) {
            session()->put('resdiary_access_token', $response->json()['access_token']);
            session()->put('resdiary_refresh_token', $response->json()['refresh_token']);

            $status = 'pending_hotel_selection';
        } else {
            $status = 'success';
            $hotel = $hotels->first();
            //If the connection already exists, update the access token and refresh token

            $connection = $hotels->first()->connections->where('key', 'resdiary_access_token')->first();
            if ($connection) {
                $connection->value = $response->json()['access_token'];
                $connection->save();
            } else {
                $connection = new Connection();
                $connection->key = 'resdiary_access_token';
                $connection->value = $response->json()['access_token'];
                $connection->hotel_id = $hotel->id;
                $connection->save();
            }

            $connection = $hotels->first()->connections->where('key', 'resdiary_refresh_token')->first();
            if ($connection) {
                $connection->value = $response->json()['refresh_token'];
                $connection->save();
            } else {
                $connection = new Connection();
                $connection->key = 'resdiary_refresh_token';
                $connection->value = $response->json()['refresh_token'];
                $connection->hotel_id = $hotel->id;
                $connection->save();
            }
        }

        return view('admin.resdiary.callback', ['status' => $status, 'hotels' => $hotels]);

    }

    public function setHotel(Request $request)
    {
        $hotel_id = $request->hotel_id;
        $access_token = session()->get('resdiary_access_token');
        $refresh_token = session()->get('resdiary_refresh_token');

        $connection = new Connection();
        $connection->key = 'resdiary_access_token';
        $connection->value = $access_token;
        $connection->hotel_id = $hotel_id;
        $connection->save();

        $connection = new Connection();
        $connection->key = 'resdiary_refresh_token';
        $connection->value = $refresh_token;
        $connection->hotel_id = $hotel_id;
        $connection->save();

        return view('admin.resdiary.callback', ['status' => 'success', 'hotels' => []]);
    }

    public function getAvailability(Request $request)
    {

        $hotel_id = $request->hotel_id ?? 2;
        $date = $request->date ?? "2024-11-15"; //date('Y-m-d');
        $partySize = $request->party_size ?? 2;

        $hotel = Hotel::find($hotel_id);
        $access_token = $hotel->connections->where('key', 'resdiary_access_token')->first()->value;
//        dd($access_token);
        $resdiary_microsite_name = $hotel->connections->where('key', 'resdiary_microsite_name')->first()->value;

        $availability = new Availability($this->is_test);
        $data = $availability->getAvailability($access_token, $resdiary_microsite_name, $date, $partySize);

        return response()->json($data);
    }


    private function generateCodeVerifier()
    {
        return bin2hex(random_bytes(64));  // 128-character string
    }

    private function generateCodeChallenge($codeVerifier)
    {
        return rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
    }
}
