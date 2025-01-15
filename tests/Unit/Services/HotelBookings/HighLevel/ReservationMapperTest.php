<?php

namespace Tests\Unit\Services\HotelBookings\HighLevel;

use App\Services\HotelBookings\Highlevel\ReservationMapper;
use PHPUnit\Framework\TestCase;

class ReservationMapperTest extends TestCase
{
    function test_maps_reserrvations_response()
    {
        $testResponse = 
        '{
        "data": [
            {
            "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
            "hotel": "bd8deb49-c184-41a6-a36c-f09798506dae",
            "booking": "1602232867",
            "status": "active",
            "status_at": "2019-02-14T00:00:00+00:00",
            "label": "John doe",
            "channel": "BDC",
            "referrer": "Some Referrer",
            "purpose": "leisure",
            "booked": "2019-02-14T00:00:00+00:00",
            "nights": 1,
            "arrive": "2019-02-14T00:00:00+00:00",
            "final": "2019-02-14T00:00:00+00:00",
            "depart": "2019-02-14T00:00:00+00:00",
            "checked-in": "2019-02-14T00:00:00+00:00",
            "checked-out": "2019-02-14T00:00:00+00:00",
            "adults": 2,
            "children": 1,
            "price": 100.99,
            "price-breakdown": {
                "2019-02-14": {
                "Accommodation": "54.00",
                "Bar Drinks": "2.20"
                },
                "2019-02-15": {
                "Till Food": "16.00"
                }
            },
            "voucher": {
                "code": "ABC",
                "description": "Description of Voucher",
                "adjustment": 25
            },
            "loyalty": "ABC123456789",
            "invoices": {
                "guest": {
                "id": 150,
                "net": 100,
                "vat": 20,
                "gross": 120,
                "paid": 50,
                "balance": 70
                },
                "corporation": {
                "id": 150,
                "net": 100,
                "vat": 20,
                "gross": 120,
                "paid": 50,
                "balance": 70
                }
            },
            "guest": {
                "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
                "name": "John Doe",
                "email": "john.doe@example.com",
                "phone": "01223 444555",
                "address": {
                "line1": "123 Fake Street",
                "line2": "Fake Town",
                "postcode": "AA11 1AA",
                "country": "United Kingdom"
                },
                "marketing": {
                "email": true,
                "mail": true,
                "phone": true
                }
            },
            "corporation": {
                "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
                "name": "Some Corporation",
                "email": "hello@corporation.com",
                "phone": "01223 444555",
                "address": {
                "address": "Corporation address, Somewhere",
                "postcode": "AA11 1AA",
                "country": "United Kingdom"
                },
                "grace_period": 150,
                "marketing": {
                "email": true,
                "mail": true,
                "phone": true
                }
            },
            "roomType": {
                "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
                "code": "sng",
                "name": "Single room"
            },
            "room": {
                "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
                "type": "room",
                "number": "2"
            },
            "rate": {
                "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
                "rateCode": "basic",
                "roomCode": "sng",
                "title": "Basic rate"
            },
            "package": {
                "id": "7",
                "code": "bnb",
                "title": "Bed and Breakfast"
            },
            "creator": {
                "id": "bd8deb49-c184-41a6-a36c-f09798506dae",
                "name": "John Doe",
                "email": "john.doe@example.com"
            },
            "booked_at": "2019-02-14T00:00:00+00:00",
            "deleted_at": "2019-02-14T00:00:00+00:00"
            }
        ],
        "messages": {
            "debug": [
            {
                "message": "module:action:result",
                "context": {
                "someData": "someValue"
                }
            }
            ],
            "info": [],
            "success": [],
            "notice": [],
            "warning": [],
            "validation": [],
            "error": [],
            "critical": [],
            "alert": [],
            "emergency": []
        },
        "meta": {
            "statusCode": 200,
            "reasonPhrase": "OK",
            "headers": {},
            "pagination": {
            "length_aware": true,
            "current_page": 1,
            "first_page_url": "https://website.com/current/path?page=1",
            "from": 0,
            "next_page_url": "https://website.com/current/path?page=2",
            "per_page": 15,
            "prev_page_url": null,
            "to": 15,
            "has_pages": true,
            "has_more_pages": true,
            "total": 18,
            "last_page": 2
            },
            "count": 18
        }
        }';

        $responseObject = json_decode($testResponse);
        $Reservations = [];
        foreach($responseObject->data as $reservationRaw)
        {
            $Reservations[] = ReservationMapper::mapReservation($reservationRaw);
        } 

        $this->assertEquals("John Doe",$Reservations[0]->name);
        $this->assertEquals("john.doe@example.com",$Reservations[0]->email);
        $this->assertEquals("2019-02-14T00:00:00+00:00",$Reservations[0]->HotelDates->checkinString);
        $this->assertEquals(1550102400,$Reservations[0]->HotelDates->checkin);
        $this->assertEquals("2",$Reservations[0]->roomNumber);
        $this->assertEquals("bd8deb49-c184-41a6-a36c-f09798506dae",$Reservations[0]->externalBookingId);

    }
}