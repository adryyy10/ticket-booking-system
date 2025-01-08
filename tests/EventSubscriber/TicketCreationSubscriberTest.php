<?php

namespace App\Tests\EventSubscriber;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Event\EventCreatedEvent;
use App\EventSubscriber\TicketCreationSubscriber;
use App\Interface\Ticket\TicketPostRepositoryInterface;
use PHPUnit\Framework\TestCase;

class TicketCreationSubscriberTest extends TestCase
{
    private TicketPostRepositoryInterface $ticketPostRepository;
    private TicketCreationSubscriber $subscriber;

    protected function setUp(): void
    {
        $this->ticketPostRepository = $this->createMock(TicketPostRepositoryInterface::class);
        $this->subscriber = new TicketCreationSubscriber($this->ticketPostRepository);
    }

    public function testOnEventCreatedCreatesCorrectNumberOfTickets(): void
    {
        $event = new Event();
        $event->setName('Test Event');
        $event->setTotalSeats(5);
        $event->setAvailableSeats(5);

        $eventDto = $this->getMockBuilder('App\Dto\Event\CreateEventDto')
                         ->disableOriginalConstructor()
                         ->getMock();
        $eventDto->method('getTotalSeats')->willReturn(5);

        $symfonyEvent = new EventCreatedEvent($eventDto, $event);

        $this->ticketPostRepository
            ->expects($this->exactly(5))
            ->method('save')
            ->with($this->isInstanceOf(Ticket::class));

        // Act: Call the onEventCreated method
        $this->subscriber->onEventCreated($symfonyEvent);
    }
}
