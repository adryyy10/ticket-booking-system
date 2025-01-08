<?php

namespace App\Tests\Controller\Booking;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingPostControllerTest extends WebTestCase
{
    public function testPostBooking(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
            'numTickets' => 2,
        ]));

        $this->assertSame(201, $client->getResponse()->getStatusCode());

        $client->request('GET', '/event/1');
        $content = $client->getResponse()->getContent();
        $this->assertStringContainsString('"availableSeats":98', $content); // Total seats - numTickets
    }

    public function testPostBookingNotEnoughSeats(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
            'numTickets' => 1000,
        ]));

        $this->assertSame(500, $client->getResponse()->getStatusCode());
    }

    public function testInvalidData(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
        ]));

        $this->assertSame(422, $client->getResponse()->getStatusCode());
    }
}
