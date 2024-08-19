<?php

namespace App\Services\HotelBookings\HighLevel\Endpoints;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class HighlevelEndpoint
{

     /** @var Client $client */
     var $client;

     /** @var LoggerInterface $Logger */
     var $Logger;
 
     /** @var array<string> $authParams */
     var $authParams;

     /**
      * @param array<mixed> $config
      * @param Client $Client
      */
     function __construct(array $config=[], array $authParams=[], Client $Client=null, LoggerInterface $Logger=null)
     {
        $headers = [
            "X-API-Key" => $config["apiKey"]
        ];
        if(isset($authParams['responseObject']))
            $headers['Authorization'] = "Bearer ".$authParams['responseObject']->access_token;

         if($Client==null)
         {
             $Client = new Client([
                 'base_uri'        => $config["host"],
                 'timeout'         => 180,
                 'headers' => $headers,
                 
                 'http_errors' => false
             ]);
         }
         
         $this->authParams = $authParams;

         $this->client = $Client;
         $this->Logger = $Logger;
     }

     function parseAuthParams(array $params) : array
     {
        return 
        [
            "access_token" => $params["access_token"],
            "refresh_token" => $params["refresh_token"],
            "session_expires" => $params["session_expires"]
        ];
     }
   
}
