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

        $this->loadTicket($manager, 43, $firstEvent);
        $this->loadTicket($manager, 44, $firstEvent);

        $manager->flush();
    }

    private function loadTicket(ObjectManager $manager, int $seat, Event $event): void
    {
        $ticket = new Ticket();
        $ticket->setSeat($seat);
        $ticket->setEvent($event);

        $manager->persist($ticket);
    }
}
