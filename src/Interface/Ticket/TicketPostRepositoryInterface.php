<?php

namespace App\Interface\Ticket;

use App\Entity\Ticket;

interface TicketPostRepositoryInterface
{
    public function save(Ticket $ticket): void;
}
