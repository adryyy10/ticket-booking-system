<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Interface\Booking\BookingPostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository implements BookingPostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $booking): void
    {
        $this->getEntityManager()->persist($booking);
        $this->getEntityManager()->flush();
    }
}
