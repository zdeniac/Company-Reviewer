<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('hu_HU');

        for ($i = 0; $i < 50; ++$i) {
            $review = new Review();

            $review->setCompanyName($faker->company());
            $review->setRating($faker->numberBetween(1, 5));
            $review->setReviewText($faker->realText(200));
            $review->setAuthorEmail($faker->email());
            $review->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')));

            if ($faker->boolean(30)) {
                $review->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months')));
            }

            $manager->persist($review);
        }

        $manager->flush();
    }
}
