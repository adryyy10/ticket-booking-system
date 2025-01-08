<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private int $seat;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private Event $eventId;

    #[ORM\ManyToOne]
    private ?Booking $bookingId = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSeat(): int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): static
    {
        $this->seat = $seat;

        return $this;
    }

    public function getEventId(): Event
    {
        return $this->eventId;
    }

    public function setEventId(Event $eventId): static
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getBookingId(): ?Booking
    {
        return $this->bookingId;
    }

    public function setBookingId(?Booking $bookingId): static
    {
        $this->bookingId = $bookingId;

        return $this;
    }
}
