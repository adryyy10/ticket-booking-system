<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Interface\Event\EventPostRepositoryInterface;
use App\Dto\Event\CreateEventDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class EventPostController extends AbstractController
{
    #[Route('/event', name: 'app_post_event', methods: ['POST'])]
    public function index(
        #[MapRequestPayload] CreateEventDto $createEventDto,
        EventPostRepositoryInterface $eventPostRepository,
    ): JsonResponse
    {
        $event = new Event();
        $event->setName($createEventDto->getName());
        $event->setTotalSeats($createEventDto->getTotalSeats());
        $event->setAvailableSeats($createEventDto->getTotalSeats());

        $eventPostRepository->save($event);

        return $this->json(
            ['id' => $event->getId(), 'message' => 'Event created successfully'],
            JsonResponse::HTTP_CREATED
        );
    }
}
