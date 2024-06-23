<?php

namespace App\Services\HotelBookings\Entities;

use App\Services\HotelBookings\ValueObjects\HotelDates;

class Reservation
{
    /** @var string $name */
    var $name;

    /** @var string $email */
    var $email;

    /** @var HotelDates $HotelDates */
    var $HotelDates;

    function __construct(HotelDates $HotelDates)
    {
        $this->HotelDates = $HotelDates;
    }
}