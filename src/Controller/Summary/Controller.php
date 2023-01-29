<?php

namespace App\Controller\Summary;

use App\Features\SummaryFeature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/summary', name: 'app_summary_index', methods: ['GET'])]
    public function index(SummaryFeature $summaryFeature): JsonResponse
    {
        return $this->json($summaryFeature->getSummary());
    }
}
