<?php

namespace App\Services\HotelBookings;

interface IHotelBookings
{
    /**
     * @return array<Reservation> 
     * @return array 
     */
    function getYesterdaysReservations() : array;
}