<?php

namespace App\Services\HotelBookings\HighLevel\Endpoints;

use App\Services\HotelBookings\Entities\Reservation;
use App\Services\HotelBookings\Highlevel\ReservationMapper;

class Reservations extends HighlevelEndpoint
{

   /**
    * @return array<Reservation>
    */
    public function get() : array
    {  
        $endpoint = "/api/v1/reservations/search";
        $searchParams = (array) '{
  "status": {
    "type": "equal",
    "value": "active"
  },
 "booked": {
    "type": "between",
    "from": "2024-06-01",
    "to": "2024-06-23"
  }
}';

        

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
