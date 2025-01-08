<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Interface\Ticket\TicketPostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository implements TicketPostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function save(Ticket $ticket): void
    {
        $this->getEntityManager()->persist($ticket);
        $this->getEntityManager()->flush();
    }
}
