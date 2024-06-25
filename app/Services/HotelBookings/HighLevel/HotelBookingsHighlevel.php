<?php

namespace App\Services\HotelBookings\Highlevel;

use App\Services\HotelBookings\HighLevel\Endpoints\Authorise;

class HotelBookingsHighlevel
{
    /** @var array<string> $authParams */
    var $authParams;

    /**
     * @param array $config 
     * @return void 
     */
    function __construct(array $config)
    {
        $Authorise = new Authorise($config);
        $this->authParams = $Authorise->call($config);
    }
   
}
