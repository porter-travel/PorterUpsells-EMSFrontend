<?php

namespace Tests\Unit\Services\HotelBookings\HighLevel\Endpoints;

use App\Services\HotelBookings\HighLevel\Endpoints\Authorise;
use PHPUnit\Framework\TestCase;

class AuthoriseTest extends TestCase
{
    function test_sanity()
    {
        $this->assertTrue(true);
    }

    /** Disabled so as not to spam the API in the test pipeline
    function test_authorises()
    {
        $config = 
        [
            "apiKey" => "3f3WkVeHuF1iwxTxeC8vn7oZYm00U3gu7d9jx6TQ",
            "host" => "https://api.stage.dev.high-level-software.com",
            //"host" => "https://api.high-level-software.com"
            "token" => "e57ab82f1d2c9c43",
            "secret" => "6453fd736fea0b6190e27331a318a8f39da15d41013474417a78cf96858d8a2b"
        ];
        $Authorise = new Authorise($config);
        $this->assertCount(3,$Authorise->authParams);

    }
    */
}