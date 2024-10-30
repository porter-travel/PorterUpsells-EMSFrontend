<?php

namespace App\Services\ResDiary;

use Illuminate\Support\Facades\Http;

class Availability
{
    public function getAvailability($accessToken, $resdiary_microsite_name, $date, $partySize)
    {
        $response = Http::withToken($accessToken)
            ->get("https://api.rdbranch.com/api/ConsumerApi/v1/Restaurant/$resdiary_microsite_name/AvailabilitySearch", [
                'VisitDate' => $date,
                'PartySize' => $partySize,
                'ChannelCode' => 'ONLINE'
            ]);

        if ($response->successful()) {
            $data = $response->json();
            dd("success", $data);
            // Process the response data as needed
        } else {
            // Handle errors here
            $error = $response->body();
            dd("error", $error);
        }
    }
}
