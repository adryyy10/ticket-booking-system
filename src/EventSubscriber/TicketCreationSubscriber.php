<?php

namespace App\EventSubscriber;

use App\Entity\Ticket;
use App\Event\EventCreatedEvent;
use App\Interface\Ticket\TicketPostRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TicketCreationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        public TicketPostRepositoryInterface $ticketPostRepository,
    ){}

    public static function getSubscribedEvents()
    {
        return [
            EventCreatedEvent::class => 'onEventCreated',
        ];
    }

    public function onEventCreated(EventCreatedEvent $event)
    {
        $eventDto = $event->getEventDto();
        $totalSeats = $eventDto->getTotalSeats();

        for ($i = 0; $i < $totalSeats; $i++) {
            $ticket = new Ticket();
            $ticket->setSeat($i + 1);
            $ticket->setEvent($event->getEvent());
            $this->ticketPostRepository->save($ticket);
        }
    }
}