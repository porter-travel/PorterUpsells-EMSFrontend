<?php

namespace App\Services\ResDiary;

use Illuminate\Support\Facades\Http;

class Availability
{
    public function getAvailability($accessToken, $resdiary_microsite_name, $date, $partySize)
    {

        $response = Http::withToken($accessToken)
            ->post("https://api.rdbranch.com/api/ConsumerApi/v1/Restaurant/$resdiary_microsite_name/AvailabilitySearch", [
                'VisitDate' => $date,
                'PartySize' => $partySize,
                'ChannelCode' => 'ONLINE'
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data;
            // Process the response data as needed
        } else {
            // Handle errors here
            $error = $response->body();
            dd("error", $error);
        }
    }
}
