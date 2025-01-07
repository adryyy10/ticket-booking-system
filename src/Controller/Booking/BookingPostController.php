<?php

namespace App\Controller\Booking;

use App\Entity\Booking;
use App\Entity\Event;
use App\Entity\User;
use App\Interface\Booking\BookingPostRepositoryInterface;
use App\Model\CreateBookingDto;
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

        // TODO: check if numTickets are > than $event->getAvailableSeats()

        $booking = new Booking();
        $booking->setUserId($user);
        $booking->setEventId($event);
        $booking->setNumTickets($createBookingDto->getNumTickets());

        $bookingPostRepository->save($booking);

        // TODO: Deduct $event->setAvailableSeats = $event->getAvailableSeats() - $createBookingDto->getNumTickets()

        return $this->json(
            ['id' => $booking->getId(), 'message' => 'Booking created successfully'],
            JsonResponse::HTTP_CREATED
        );
    }
}
