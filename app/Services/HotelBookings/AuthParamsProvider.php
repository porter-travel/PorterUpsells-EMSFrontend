<?php

namespace App\Services\HotelBookings;

use App\Services\HotelBookings\Entities\Reservation;
use App\Services\HotelBookings\HighLevel\HotelBookingsHighlevel;
//use App\Services\HotelBookings\Highlevel\ReservationMapper;

class AuthParamsProvider
{
    
    var $filePath = "./highlevelAuth.json";
    var $cachedData = [];

    function __construct()
    {
        $this->loadData();
    }


    private function saveData()
    {
        file_put_contents($this->filePath,json_encode($this->cachedData));
    }

    private function loadData()
    {
        $this->cachedData = [];
        $currentDir = getcwd();
        if(!file_exists($this->filePath))
            $result = file_put_contents($this->filePath,"{}");
            

        $loadedFilestring = file_get_contents($this->filePath);
        if($loadedFilestring===false)
            throw new \Exception("Can't load ".$this->filePath);

        $this->cachedData = json_decode($loadedFilestring);

        if($this->cachedData===false)
            throw new \Exception("File ".$this->filePath." did not contain valid JSON");
        
       
    }

    function getParams()
    {
        return (array) $this->cachedData;
    }

    function saveParams(array $params)
    {
        $this->cachedData = $params;
        $this->saveData();
    }
}