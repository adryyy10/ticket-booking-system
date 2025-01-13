<?php

namespace App\Controller\Booking;

use App\Dto\Booking\CreateBookingDto;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BookingPostController extends AbstractController
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {}

    #[Route('/event/{id}/booking', name: 'app_post_booking', methods: ['POST'])]
    public function index(
        int $id,
        #[MapRequestPayload] CreateBookingDto $createBookingDto,
    ): JsonResponse
    {
        try {
            $booking = $this->bookingService->createBooking($id, $createBookingDto);

            return $this->json(
                ['id' => $booking->getId(), 'message' => 'Booking created successfully'],
                JsonResponse::HTTP_CREATED
            );
        } catch (\RuntimeException $e) {
            $statusCode = match ($e->getMessage()) {
                'Not enough available seats' => JsonResponse::HTTP_BAD_REQUEST,
                'Ticket already booked' => JsonResponse::HTTP_CONFLICT,
                default => JsonResponse::HTTP_SERVICE_UNAVAILABLE,
            };

            return $this->json(
                ['message' => $e->getMessage()],
                $statusCode
            );
        } catch (\Exception $e) {
            return $this->json(
                ['message' => 'An unexpected error occurred.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
