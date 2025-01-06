<?php

namespace App\Tests\Controller\Event;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventPostControllerTest extends WebTestCase
{
    public function testCreateEvent(): void
    {
        $client = static::createClient();

        $client->request('POST', '/event', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Symfony Event',
            'totalSeats' => 100,
        ]));

        // Since $this->assertResponseIsSuccessful() has compatibility problems with PHPUnit 11.0 and Symfony, we use the following code:
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }
}
