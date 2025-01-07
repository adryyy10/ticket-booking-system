<?php

namespace App\Controller\Event;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class EventGetController extends AbstractController
{
    #[Route('/event/{id}', name: 'app_get_event', methods: ['GET'])]
    public function index(
        int $id,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $event = $entityManager->getRepository(Event::class)->find($id);
        Assert::isInstanceOf($event, Event::class);

        return $this->json(['event' => $event], JsonResponse::HTTP_OK);
    }
}
