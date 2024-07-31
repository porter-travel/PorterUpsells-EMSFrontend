<?php

namespace App\Services\HotelBookings\HighLevel\Endpoints;

use App\Services\HotelBookings\Entities\Reservation;
use App\Services\HotelBookings\Highlevel\ReservationMapper;

class Reservations extends HighlevelEndpoint
{

  // e48fe378-fd81-11ee-9d39-0a593bc257b1
   /**
    * @return array<Reservation>
    */
    public function get() : array
    {  
        $endpoint = "/api/v1/reservations/search";

        $searchParams =
        [
          "booked" =>
          [
            "type" => "between",
            "from" => "2024-07-01",
            "to" => "2024-07-31"
          ]
        ];
        $searchParams += $this->authParams;

        
        $response = $this->client->request('POST', $endpoint,['json' => $searchParams]);
        $responseString = $response->getBody();
        $responseObject = json_decode($responseString);
        $reservationsArray = [];
        foreach($responseObject->data as $reservationRaw)
        {
            $reservationsArray[] = self::parseReservation($reservationRaw);     
        }

        return $reservationsArray;

    }

    public function parseReservation(object $reservationRaw) : Reservation
    {
        return ReservationMapper::mapReservation($reservationRaw);
    }
}
