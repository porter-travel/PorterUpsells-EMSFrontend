<?php

namespace App\Services\HotelBookings\HighLevel\Endpoints;

use AWS\CRT\HTTP\Response;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Authorise extends HighlevelEndpoint
{

     function call(array $params) : object
     {
        $endpoint = "/api/v1/authentication/login";
        

        $response = $this->client->request('POST', $endpoint,['json' => $params]);
        $responseString = $response->getBody();
        $responseObject = json_decode($responseString);

        return $responseObject;
     }
}
