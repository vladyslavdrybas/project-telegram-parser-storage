<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CelebrityController extends AbstractController
{
    #[Route("/contact", name: "contact_add", methods: ["POST"])]
    public function add(Request $request): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
        ]);
    }
}
