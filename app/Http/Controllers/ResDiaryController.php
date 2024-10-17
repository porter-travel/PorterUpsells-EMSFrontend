<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResDiaryController extends Controller
{
    public function install(Request $request)
    {
        $codeVerifier = $this->generateCodeVerifier();
        $codeChallenge = $this->generateCodeChallenge($codeVerifier);
// Get all query parameters
        $data = $request->query();

// Parse the authorization_uri separately if it contains more query parameters
        if (isset($data['authorization_uri'])) {
            $authorizationUri = parse_url($data['authorization_uri'], PHP_URL_QUERY);
            parse_str($authorizationUri, $authParams);

            $data['authorization_uri_params'] = $authParams;
        }

        dd($data);

        $client_id = env('RESDIARY_CLIENT_ID');
        $redirect_uri = env('RESDIARY_REDIRECT_URI');
        $scope = env('RESDIARY_SCOPE');
        $state = env('RESDIARY_STATE');
        $url = "https://resdiary.com/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&state=$state";
        return redirect($url);
    }

    public function callback(Request $request)
    {
        dd($request);
        $code = $request->code;
        $client_id = env('RESDIARY_CLIENT_ID');
        $client_secret = env('RESDIARY_CLIENT_SECRET');
        $redirect_uri = env('RESDIARY_REDIRECT_URI');
        $url = "https://resdiary.com/oauth/token";
        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri
        ];
        $response = Http::post($url, $data);
        $response = json_decode($response->body());
        $access_token = $response->access_token;
        $refresh_token = $response->refresh_token;
        $expires_in = $response->expires_in;
        $expires_at = time() + $expires_in;
        $resdiary = new ResDiary();
        $resdiary->access_token = $access_token;
        $resdiary->refresh_token = $refresh_token;
        $resdiary->expires_at = $expires_at;
        $resdiary->save();
        return redirect()->route('dashboard');
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
