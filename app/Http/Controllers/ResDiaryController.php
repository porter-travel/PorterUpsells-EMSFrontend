<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResDiaryController extends Controller
{
    public function install(Request $request)
    {
        $codeVerifier = $this->generateCodeVerifier();
        session()->save($codeVerifier);
        $codeChallenge = $this->generateCodeChallenge($codeVerifier);
// Get all query parameters
        $data = $request->query();

// Parse the authorization_uri separately if it contains more query parameters
        if (isset($data['authorization_uri'])) {
            $authorizationUri = parse_url($data['authorization_uri'], PHP_URL_QUERY);
            parse_str($authorizationUri, $authParams);

        }


        return redirect($data['authorization_uri'] . '&code_challenge=' . $codeChallenge . '&code_challenge_method=S256');


    }

    public function callback(Request $request)
    {

        $response = Http::post(env('RESDIARY_OAUTH_URL'), [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'client_id' => env('RESDIARY_CLIENT_ID'),
            'client_secret' => env('RESDIARY_CLIENT_SECRET'),
            'redirect_uri' => env('APP_URL'),
            'code_verifier' => session()->get('code_verifier')
        ]);

        dd($response);

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
