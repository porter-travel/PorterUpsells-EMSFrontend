<?php

namespace App\Services\HotelBookings\HighLevel;

use App\Services\HotelBookings\AuthParamsProvider;
use App\Services\HotelBookings\HighLevel\Endpoints\Authorise;
use App\Services\HotelBookings\HighLevel\Endpoints\ReservationEndpoint;
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

        $AuthParamsProvider = new AuthParamsProvider();
        $params = $AuthParamsProvider->getParams();
        $AuthObject = new HighLevelAuthObject($params);
        if($AuthObject->isValid())
        {
            $this->authParams = $AuthObject->getAuthParams();
        }
        else
        {

            $Authorise = new Authorise($config);
            $this->authParams = $Authorise->authParams;
            $this->authParams +=  $config;
            $this->config = $config;
            $AuthParamsProvider->saveParams($this->authParams);
        }

    }

    /**
     *
     * @return array<Reservation>
     */
    function getCloseReservations() : array
    {
        $ReservationsEndpoint = new Reservations($this->authParams);
        $reservationsArray = $ReservationsEndpoint->get();

        return $reservationsArray;
    }

    function getReservationByRef(string $bookingRef) : array
    {
        $ReservationEndpoint = new ReservationEndpoint($this->authParams);
        $reservationArray = $ReservationEndpoint->get($bookingRef);

        return $reservationArray;
    }

}
