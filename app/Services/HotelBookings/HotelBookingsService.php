<?php

namespace App\Services\HotelBookings;

use App\Services\HotelBookings\Entities\Reservation;
use App\Services\HotelBookings\HighLevel\HotelBookingsHighlevel;
//use App\Services\HotelBookings\Highlevel\ReservationMapper;

class HotelBookingsService
{

    /** @var array<mixed> $config */
    var $config;

    /**
     *
     * @param array<mixed> $config
     * @return void
     */
    function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array<Reservation>
     */
    function fetchReservations() : array
    {
        $HotelBookingsHighlevel = new HotelBookingsHighlevel($this->config);
        $ReservationsArray = $HotelBookingsHighlevel->getCloseReservations();
        return $ReservationsArray;
    }

}
