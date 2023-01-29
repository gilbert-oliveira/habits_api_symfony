<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TesteController extends AbstractController
{
    #[Route('/teste', name: 'app_teste_index', methods: ['POST'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path'    => 'src/Controller/TesteController.php',
        ]);
    }
}
