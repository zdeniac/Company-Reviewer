<?php

namespace App\Controller;

use App\Review\ReviewListFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    #[Route('/reviews/{page}', name: 'review.index', requirements: ['page' => '\d+'])]
    public function index(
        ReviewListFetcher $reviewListProvider,
        int $page = 1
    ): Response {
        $reviewList = $reviewListProvider->getPaginated($page);
        return $this->render('review/index.html.twig', [
            'reviews' => $reviewList->getItems(),
            'totalPages' => $reviewList->getPagination()->getTotalPages(),
            'currentPage' => $page,
        ]);
    }
}
