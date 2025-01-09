<?php

namespace App\Controller\Booking;

use App\Entity\Booking;
use App\Entity\Event;
use App\Entity\User;
use App\Interface\Booking\BookingPostRepositoryInterface;
use App\Dto\Booking\CreateBookingDto;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class BookingPostController extends AbstractController
{
    #[Route('/event/{id}/booking', name: 'app_post_booking', methods: ['POST'])]
    public function index(
        int $id,
        #[MapRequestPayload] CreateBookingDto $createBookingDto,
        EntityManagerInterface $entityManager,
        BookingPostRepositoryInterface $bookingPostRepository,
    ): JsonResponse
    {
        $event = $entityManager->getRepository(Event::class)->find($id);
        Assert::isInstanceOf($event, Event::class);

        // TODO: replace by security user
        $user = $entityManager->getRepository(User::class)->find($createBookingDto->getUserId());
        Assert::isInstanceOf($user, User::class);

        $ticketCount = count($createBookingDto->getTickets());

        // TODO: Abstract the logic to a service
        if ($event->getAvailableSeats() < $ticketCount) {
            return $this->json(
                ['message' => 'Not enough available seats'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $booking = new Booking();
        $booking->setUser($user);
        $booking->setEvent($event);

        foreach ($createBookingDto->getTickets() as $ticketSeat) {
            $ticket = $entityManager->getRepository(Ticket::class)->findOneBy(['seat' => $ticketSeat, 'event' => $event]);
            Assert::isInstanceOf($ticket, Ticket::class);

            if ($ticket->getBooking() !== null) {
                return $this->json(
                    ['message' => 'Ticket already booked'],
                    JsonResponse::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $booking->addTicket($ticket); // We also add $ticket->setBooking($booking) in this statement
        }

        // Deduct the number of tickets from the available seats
        // TODO: Abstract the logic to a subscriber
        $event->setAvailableSeats($event->getAvailableSeats() - $ticketCount);

        $bookingPostRepository->save($booking);

        return $this->json(
            ['id' => $booking->getId(), 'message' => 'Booking created successfully'],
            JsonResponse::HTTP_CREATED
        );
    }
}
