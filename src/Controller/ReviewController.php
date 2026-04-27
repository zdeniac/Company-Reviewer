<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    #[Route('/reviews/{page}', name: 'reviews')]
    public function index(ReviewRepository $reviewRepository, int $page = 1): JsonResponse
    {
        dd($reviewRepository->findAllPaginated($page));
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ReviewController.php',
        ]);
    }
}
