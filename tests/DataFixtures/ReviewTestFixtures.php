<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

final class ReviewTestFixtures
{
    public static function load(EntityManagerInterface $em): void
    {
        $data = [
            ['Apple', 5, 'Great product', 'a@test.com'],
            ['Apple', 4, 'Good', 'b@test.com'],
            ['Google', 3, 'Ok', 'c@test.com'],
        ];

        foreach ($data as [$company, $rating, $text, $email]) {
            $review = new Review();
            $review->setCompanyName($company);
            $review->setRating($rating);
            $review->setReviewText($text);
            $review->setAuthorEmail($email);
            $review->setCreatedAt(new \DateTimeImmutable('2024-01-01'));

            $em->persist($review);
        }

        $em->flush();
    }
}
