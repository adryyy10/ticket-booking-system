<?php

namespace App\Event;

use App\Dto\Event\CreateEventDto;
use App\Entity\Event as EntityEvent;
use Symfony\Contracts\EventDispatcher\Event;

class EventCreatedEvent extends Event
{
    public const NAME = 'event.created';

    public function __construct(
        public CreateEventDto $eventDto, 
        public EntityEvent $event
    ){}

    public function getEventDto(): CreateEventDto
    {
        return $this->eventDto;
    }

    public function getEvent(): EntityEvent
    {
        return $this->event;
    }
}