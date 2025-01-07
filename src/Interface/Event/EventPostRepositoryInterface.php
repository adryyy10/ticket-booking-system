<?php

namespace App\Interface\Event;

use App\Entity\Event;

interface EventPostRepositoryInterface
{
    public function save(Event $event): void;
}
