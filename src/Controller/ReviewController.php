<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Review\ReviewListFetcher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    #[Route('/', name: 'review.home', methods: ['GET'])]
    #[Route('/reviews/{page}', name: 'review.index', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function index(ReviewListFetcher $reviewListFetcher, Request $request, int $page = 1): Response
    {
        $companyName = $request->query->get('companyName');
        $reviewList = $reviewListFetcher->getPaginated($page, companyName: $companyName);

        return $this->render('review/index.html.twig', [
            'reviews' => $reviewList->getItems(),
            'pagination' => $reviewList->getPagination(),
            'companyName' => $companyName,
        ]);
    }

    #[Route('/reviews/{id}/show', name: 'review.show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    #[Route('/reviews/new', name: 'review.new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setCreatedAt(new \DateTimeImmutable());

            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Köszönjük a véleményed!');

            return $this->redirectToRoute('review.index');
        }

        return $this->render('review/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
