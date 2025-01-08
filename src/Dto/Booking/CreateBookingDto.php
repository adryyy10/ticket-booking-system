<?php

namespace App\Dto\Booking;

class CreateBookingDto
{

    public function __construct(
        private int $userId,
        private int $numTickets,
    ){}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNumTickets(): int
    {
        return $this->numTickets;
    }
}
