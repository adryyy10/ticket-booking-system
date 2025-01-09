<?php

namespace App\Dto\Booking;

use App\Entity\Ticket;
use Doctrine\Common\Collections\Collection;

class CreateBookingDto
{

    /**
     * @param int $userId
     * @param int[] $tickets
    */
    public function __construct(
        private int $userId,
        private array $tickets,
    ){}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }
}
