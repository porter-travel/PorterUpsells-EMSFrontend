<?php

namespace App\Http\Controllers;

use App\Models\IntegrationToken;
use Illuminate\Http\Request;

class IntegrationTokenController extends Controller
{
    public function viewHighLevelTokens()
    {
        $tokens = IntegrationToken::where('type', 'highlevel')->get();
        return view('superadmin.highlevel-tokens', ['tokens' => $tokens]);
    }

    public function delete($id){
        $token = IntegrationToken::find($id);
        $token->delete();
        return redirect()->route('highlevel-tokens');
    }

    public function storeHighLevelToken(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'friendly_name' => 'required|string',
        ]);

        $token = new IntegrationToken();
        $token->token = $request->client_id;
        $token->friendly_name = $request->friendly_name;
        $token->secret = $request->client_secret;
        $token->type = 'highlevel';
        $token->save();

        return redirect()->route('highlevel-tokens');
    }
}
