<?php

namespace App\Controller\Habits;

use App\Entity\Day;
use App\Entity\Habit;
use App\Form\HabitType;
use App\Repository\DayRepository;
use App\Repository\HabitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    public function __construct(
        private readonly HabitRepository $habitRepository,
        private readonly DayRepository   $dayRepository,
    )
    {
    }

    #[Route('/habits', name: 'api_habits_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $form = $this->createForm(HabitType::class, new Habit());
        $form->submit($request->toArray());

        if ($form->isValid()) {
            $habit = $form->getData();
            $this->habitRepository->save($habit);

            return $this->json($habit);
        }

        return $this->json($form->getErrors(true));
    }

    #[Route('/habits/{id}/toggle', name: 'app_habits_toggle', methods: ['PATCH'])]
    public function toggle(Habit $habit): JsonResponse
    {

        $day = $this->dayRepository->findOneBy([
            'date' => (new \DateTimeImmutable())->setTime(0, 0),
        ]);

        if (!$day) {
            $day = new Day();
        }

        $habit->getDays()->contains($day)
            ? $habit->removeDay($day)
            : $habit->addDay($day);

        $this->habitRepository->save($habit);

        return $this->json($habit);
    }
}
