<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Review\ReviewListFetcher;
use App\Tests\DataFixtures\ReviewTestFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReviewListFetcherTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private ReviewListFetcher $fetcher;

    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test', 'debug' => true]);
        $container = static::getContainer();

        $this->em = $container->get(EntityManagerInterface::class);
        $this->fetcher = $container->get(ReviewListFetcher::class);

        $this->clearDatabase();
        ReviewTestFixtures::load($this->em);
    }

    private function clearDatabase(): void
    {
        $this->em->createQuery('DELETE FROM App\Entity\Review r')->execute();
    }

    public function testPaginationWithoutFilter(): void
    {
        $result = $this->fetcher->getPaginated(page: 1, perPage: 10);

        $this->assertCount(3, $result->getItems());
        $this->assertSame(1, $result->getPagination()->getTotalPages());
    }

    public function testPaginationWithFilter(): void
    {
        $result = $this->fetcher->getPaginated(page: 1, perPage: 10, companyName: 'Apple');

        $this->assertCount(2, $result->getItems());
        $this->assertSame(1, $result->getPagination()->getTotalPages());
    }

    public function testPaginationSecondPage(): void
    {
        $result = $this->fetcher->getPaginated(page: 2, perPage: 10);

        $this->assertLessThanOrEqual(10, count($result->getItems()));
    }
}
