<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResDiaryController extends Controller
{
    public function install(Request $request)
    {
        $codeVerifier = $this->generateCodeVerifier();
        session()->put('code_verifier', $codeVerifier);
        $codeChallenge = $this->generateCodeChallenge($codeVerifier);
// Get all query parameters
        $data = $request->query();

// Parse the authorization_uri separately if it contains more query parameters
        if (isset($data['authorization_uri'])) {
            $authorizationUri = parse_url($data['authorization_uri'], PHP_URL_QUERY);
            parse_str($authorizationUri, $authParams);

        }


        $response_type = 'code'; // This is required when getting the authorization code

        $authorizationUrl = $data['authorization_uri']
            . '&response_type=' . $response_type
            . '&code_challenge=' . $codeChallenge
            . '&code_challenge_method=S256';

        return redirect($authorizationUrl);


    }

    public function callback(Request $request)
    {

        $codeVerifier = session()->get('code_verifier');
        if (!$codeVerifier) {
            dd('Code verifier is missing');
        }


        $response = Http::asForm()->post(env('RESDIARY_OAUTH_URL'), [
            'client_id' => env('RESDIARY_CLIENT_ID'),
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'client_secret' => env('RESDIARY_CLIENT_SECRET'),
            'redirect_uri' => env('APP_URL') . '/resdiray/callback',
            'code_verifier' => $codeVerifier,
            'response_type' => 'code'
        ]);

        if ($response->failed()) {
            dd($response->body()); // Log or display the error for debugging
        }

        dd($response->json());
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
