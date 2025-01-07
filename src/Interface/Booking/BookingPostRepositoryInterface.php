<?php

namespace App\Interface\Booking;

use App\Entity\Booking;

interface BookingPostRepositoryInterface
{
    public function save(Booking $booking): void;
}
