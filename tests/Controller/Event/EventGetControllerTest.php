<?php

namespace App\Tests\Controller\Event;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventGetControllerTest extends WebTestCase
{
    public function testGetEvent(): void
    {
        $client = static::createClient();

        $client->request('GET', '/event/1');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
