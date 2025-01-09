<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {

        $firstEvent = $this->getReference(EventFixtures::FIRST_EVENT, Event::class);

        $ticket = new Ticket();
        $ticket->setSeat(43);
        $ticket->setEvent($firstEvent);
        
        $manager->persist($ticket);

        $manager->flush();
    }
}
