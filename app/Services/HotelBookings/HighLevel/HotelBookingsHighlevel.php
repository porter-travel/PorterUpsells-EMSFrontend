<?php

namespace App\Services\HotelBookings\Highlevel;

use App\Services\HotelBookings\HighLevel\Endpoints\Authorise;
use App\Services\HotelBookings\HighLevel\Endpoints\Reservations;

class HotelBookingsHighlevel
{
    /** @var array<string> $authParams */
    var $authParams;

    /** @var array<string> $config */
    var $config;

    /**
     * @param array $config 
     * @return void 
     */
    function __construct(array $config)
    {
        $Authorise = new Authorise($config);
        $this->authParams = $Authorise->authParams;
        $this->config = $config;
    }

    /**
     * 
     * @return array<Reservation>
     */
    function getYesterdaysReservations() : array
    {
        $ReservationsEndpoint = new Reservations($this->config,$this->authParams);
        $reservationsArray = $ReservationsEndpoint->get();

        return $reservationsArray;
    }
   
}
