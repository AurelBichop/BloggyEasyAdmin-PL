<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    #[Route('/demo', name: 'app_home')]
    public function index(): JsonResponse
    {

        return $this->json([
            'message' => 'Welcome to your new Home controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
}
