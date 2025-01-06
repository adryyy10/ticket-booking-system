<?php

namespace App\Controller\Event;

use App\Model\CreateEventDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class EventPostController extends AbstractController
{
    #[Route('/event', name: 'app_post_event')]
    public function index(
        #[MapRequestPayload] CreateEventDto $createEventDto,
    ): JsonResponse
    {
        // TODO: Persist $createEventDto to the database
        return $this->json([], JsonResponse::HTTP_CREATED);
    }
}
