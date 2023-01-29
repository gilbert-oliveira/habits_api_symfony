<?php

namespace App\Controller\Day;

use App\Repository\HabitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    public function __construct(private readonly HabitRepository $habitRepository)
    {
    }

    #[Route('/day', name: 'app_day_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $date = $request->query->get('date');

        $days = $this->habitRepository->findByDay(new \DateTimeImmutable($date));

        return $this->json($days);
    }
}
