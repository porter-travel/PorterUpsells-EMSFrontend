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
 
     /**
      * @param array<mixed> $config
      * @param Client $Client
      */
     function __construct(array $config=[], Client $Client=null, LoggerInterface $Logger=null)
     {
         if($Client==null)
         {
             $Client = new Client([
                 'base_uri'        => $config["host"],
                 'timeout'         => 180,
                 'headers' => 
                 [
                     "X-API-Key" => $config["apiKey"]
                 ],
                 'http_errors' => false
             ]);
         }
 
         $this->client = $Client;
         $this->Logger = $Logger;
     }
   
}
