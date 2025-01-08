<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Interface\Event\EventPostRepositoryInterface;
use App\Dto\Event\CreateEventDto;
use App\Event\EventCreatedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class EventPostController extends AbstractController
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    ) {}

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

        // Dispatch event in order to create new Tickets
        $symfonyEvent = new EventCreatedEvent($createEventDto, $event);
        $this->eventDispatcher->dispatch($symfonyEvent);

        return $this->json(
            ['id' => $event->getId(), 'message' => 'Event created successfully'],
            JsonResponse::HTTP_CREATED
        );
    }
}
