<?php

namespace App\Services\HotelBookings\HighLevel\Endpoints;

use App\Services\HotelBookings\Entities\Reservation;
use App\Services\HotelBookings\HighLevel\ReservationMapper;

class Reservations extends HighlevelEndpoint
{

  // e48fe378-fd81-11ee-9d39-0a593bc257b1
   /**
    * @return array<Reservation>
    */
    public function get() : array
    {
        $endpoint = "/api/v1/reservations/search";

        $daysRange = 31;
        $from = date("Y-m-d",time() + (3 * 24 * 60 * 60));
        $to = date("Y-m-d",time() + ($daysRange * 24 * 60 * 60));
        $searchParams =
        [
          "arriving" =>
          [
            "type" => "between",
            "from" => $from,
            "to" => $to
          ],
            "checked-in" =>
            [
                "type" => "bool",
                "value" => false
            ]
        ];
        $searchParams += $this->parseAuthParams($this->authParams);


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
