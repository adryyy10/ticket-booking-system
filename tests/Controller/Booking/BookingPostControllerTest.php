<?php

namespace App\Tests\Controller\Booking;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingPostControllerTest extends WebTestCase
{
    public function testPostBooking(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
            'tickets' => [43],
        ]));

        $this->assertSame(201, $client->getResponse()->getStatusCode());

        $client->request('GET', '/event/1');
        $content = $client->getResponse()->getContent();
        $this->assertStringContainsString('"availableSeats":99', $content); // Total seats - numTickets
    }

    public function testInvalidData(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
        ]));

        $this->assertSame(422, $client->getResponse()->getStatusCode());
    }

    public function testPostBookingNotEnoughSeats(): void
    {
        $client = static::createClient();

        $ticket = $this->getContainer()->get('doctrine')->getRepository(Ticket::class)->find(1);

        $client->request('POST', '/event/2/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
            'tickets' => [43],
        ]));

        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function testPostBookingAlreadyBooked(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
            'tickets' => [44],
        ]));
        $this->assertSame(201, $client->getResponse()->getStatusCode());

        $client->request('POST', '/event/1/booking', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'userId' => 1,
            'tickets' => [44],
        ]));
        $this->assertSame(409, $client->getResponse()->getStatusCode());
    }
}
