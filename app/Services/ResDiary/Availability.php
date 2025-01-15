<?php

namespace App\Services\ResDiary;

use Illuminate\Support\Facades\Http;

class Availability
{

    public $is_test = false;

    public function __construct($is_test = false)
    {
        $this->is_test = $is_test;
    }

    public function getAvailability($accessToken, $resdiary_microsite_name, $date, $partySize)
    {

        if ($this->is_test) {
            return [
                'data' => [
                    'Availability' => [
                        [
                            'Time' => '12:00',
                            'Availability' => 2
                        ]
                    ]
                ]
            ];
        }

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
