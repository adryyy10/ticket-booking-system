<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const FIRST_EVENT = 'first-event';

    public function load(ObjectManager $manager): void
    {
        $firstEvent = $this->loadEvents($manager, 'Event 1', 100, 100);
        $this->loadEvents($manager, 'Event 2', 0, 0); // Empty event

        $manager->flush();

        $this->addReference(self::FIRST_EVENT, $firstEvent);
    }

    private function loadEvents(
        ObjectManager $manager,
        string $name,
        int $totalSeats,
        int $availableSeats,
    ): Event
    {
        $event = new Event();
        $event->setName($name);
        $event->setTotalSeats($totalSeats);
        $event->setAvailableSeats($availableSeats);
        $manager->persist($event);

        return $event;
    }
}
