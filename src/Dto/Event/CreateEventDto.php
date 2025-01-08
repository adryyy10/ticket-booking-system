<?php

namespace App\Dto\Event;

class CreateEventDto
{

    public function __construct(
        private string $name,
        private int $totalSeats,
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getTotalSeats(): int
    {
        return $this->totalSeats;
    }
}
