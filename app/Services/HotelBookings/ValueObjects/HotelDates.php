<?php

namespace App\Services\HotelBookings\ValueObjects;

use DateTime;

class HotelDates
{
    /** @var int $checkin **/
    var $checkin;

    /** @var int $checkout **/
    var $checkout;

    /** @var string $checkinString **/
    var $checkinString;

    /** @var string $checkoutString **/
    var $checkoutString;

    /** @var int $daysLength */
    var $daysLength;

    /**
     * @param mixed $checkinString
     * @param mixed $checkoutString
     */
    public function __construct($checkinString=null, $checkoutString=null)
    {
        if($checkinString == null && $checkoutString == null)
        {
            $checkin = strtotime("+3 month");
            $checkinString = date("Y-m-d",$checkin);
            $checkout = strtotime("+3 month +2 week");
            $checkoutString = date("Y-m-d",$checkout);
        }
        else
        {
            $checkin = strtotime((string) $checkinString);
            $checkout = strtotime((string) $checkoutString);
        }

        if($checkin)
            $this->checkin = $checkin;

        if($checkout)
            $this->checkout = $checkout;

        if($checkin!=false && $checkout!=false)
            $this->daysLength = $this->getDaysDiff($checkinString, $checkoutString);

        $this->checkinString = $checkinString;
        $this->checkoutString = $checkoutString;
    }

    /**
     * @param string $checkin
     * @param string $checkout
     */
    private function getDaysDiff(string $checkin, string $checkout) : int
    {
        $date1 = new DateTime($checkin);
        $date2 = new DateTime($checkout);
        $days  = (int) $date2->diff($date1)->format('%a');

        return $days;
    }
}