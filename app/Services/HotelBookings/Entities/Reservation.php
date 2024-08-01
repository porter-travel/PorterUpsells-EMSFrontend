<?php

namespace App\Services\HotelBookings\Entities;

use App\Services\HotelBookings\ValueObjects\HotelDates;

class Reservation
{
    /** @var string $externalBookingId */
    var $externalBookingId;

    /** @var string $hotelId */
    var $hotelId;

    /** @var string $name */
    var $name;

    /** @var string $email */
    var $email;

    /** @var HotelDates $HotelDates */
    var $HotelDates;

    /** @var string $roomNumber */
    var $roomNumber;

    function __construct(HotelDates $HotelDates)
    {
        $this->HotelDates = $HotelDates;
    }
}