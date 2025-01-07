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
    }
}
