<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $event->setName('Testing event');
        $event->setTotalSeats(100);
        $event->setAvailableSeats(100);
        $manager->persist($event);

        $manager->flush();
    }
}
