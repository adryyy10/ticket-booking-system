<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Event;
use App\Entity\User;
use App\Interface\Booking\BookingPostRepositoryInterface;
use App\Dto\Booking\CreateBookingDto;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\RetryableException;
use Doctrine\DBAL\LockMode;
use Webmozart\Assert\Assert;

class BookingService
{
    public function __construct(
        private EntityManagerInterface $entityManager, 
        private BookingPostRepositoryInterface $bookingPostRepository, 
        private int $maxRetries = 3
    ) {}

    public function createBooking(int $eventId, CreateBookingDto $createBookingDto): Booking
    {
        $attempt = 0;

        while ($attempt < $this->maxRetries) {
            $attempt++;
            $this->entityManager->getConnection()->beginTransaction();

            try {
                $event = $this->entityManager->getRepository(Event::class)->find($eventId);
                Assert::isInstanceOf($event, Event::class);

                $user = $this->entityManager->getRepository(User::class)->find($createBookingDto->getUserId());
                Assert::isInstanceOf($user, User::class);

                $ticketCount = count($createBookingDto->getTickets());

                if ($event->getAvailableSeats() < $ticketCount) {
                    throw new \RuntimeException('Not enough available seats');
                }

                $booking = new Booking();
                $booking->setUser($user);
                $booking->setEvent($event);

                foreach ($createBookingDto->getTickets() as $ticketSeat) {
                    $ticket = $this->entityManager->getRepository(Ticket::class)
                        ->findOneBy(['seat' => $ticketSeat, 'event' => $event]);
                    Assert::isInstanceOf($ticket, Ticket::class);
                    $this->entityManager->lock($ticket, LockMode::PESSIMISTIC_WRITE);

                    if ($ticket->getBooking() !== null) {
                        throw new \RuntimeException('Ticket already booked');
                    }

                    $booking->addTicket($ticket);
                }

                $event->setAvailableSeats($event->getAvailableSeats() - $ticketCount);

                $this->bookingPostRepository->save($booking);
                $this->entityManager->flush();
                $this->entityManager->commit();

                return $booking;
            } catch (\Doctrine\DBAL\Exception\DeadlockException | \Doctrine\DBAL\Exception\LockWaitTimeoutException | RetryableException $e) {
                $this->entityManager->rollBack();
                if ($attempt >= $this->maxRetries) {
                    throw new \RuntimeException('Could not complete booking due to high traffic. Please try again.');
                }
                usleep(100000); // 100ms
            } catch (\Exception $e) {
                $this->entityManager->rollBack();
                throw $e;
            }
        }

        throw new \RuntimeException('Could not complete booking. Please try again later.');
    }
}
