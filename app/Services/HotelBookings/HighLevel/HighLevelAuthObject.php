<?php

namespace App\Services\HotelBookings\HighLevel;


class HighLevelAuthObject
{
    var $access_token;

    var $refresh_token;

    var $session_expires;

    var $apiKey;

    var $host;

    function __construct(array $params)
    {
        if($params==[])
            return;
        $this->access_token = $params["access_token"];
        $this->refresh_token = $params["refresh_token"];
        $this->session_expires = $params["session_expires"];
        $this->apiKey = $params["apiKey"];
        $this->host = $params["host"];
    }

    function isValid() : bool
    {
        if ($this->access_token==null)
            return false;
            
        if ($this->tokenHasExpired())
            return false;

        return true;
    }

    function tokenHasExpired() : bool
    {
        $timestamp = strtotime($this->session_expires);
        return $timestamp>=time();
    }

    function getAuthParams() : array
    {
        return
        [
            "access_token" => $this->access_token,
            "refresh_token" => $this->refresh_token,
            "session_expires" => $this->session_expires,
            "apiKey" => $this->apiKey,
            "host" => $this->host
        ];
    }
}