<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{

    public function test()
    {
        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);

        echo $result->choices[0]->message->content;
    }

    public function rewrite_product_descriptions(Request $request){
        $product = $request->input('product_description');
        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ["role" => "user", "content" => "Rewrite the following product description in a more engaging way:\n\n\"$product\""]
            ],
            'max_tokens' => 400,
            'temperature' => 0.5,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        return response()->json([
            'product' => $product,
            'result' => $result->choices[0]->message->content
        ]);
    }
}
