<?php
namespace App\Services\HotelBookings\HighLevel;

use App\Services\HotelBookings\ValueObjects\HotelDates;
use App\Services\HotelBookings\Entities\Reservation;

class ReservationMapper
{


    static function mapReservation(object $reservationObject) : Reservation
    {
        $HotelDates = new HotelDates($reservationObject->arrive,$reservationObject->depart);
        $Reservation = new Reservation($HotelDates);

        $Reservation->name =  $reservationObject->guest->name;
        $Reservation->email = $reservationObject->guest->email;
        $Reservation->externalBookingId = $reservationObject->id;
        $Reservation->roomNumber = $reservationObject->room->number;
        $Reservation->hotelId = $reservationObject->hotel;
        $Reservation->checkedInString = $reservationObject->checked_in;
        return $Reservation;

    }

}
