<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Review\ReviewListFetcher;
use App\Tests\DataFixtures\ReviewTestFixtures;

class ReviewListFetcherTest extends AbstractDatabaseTestCase
{
    private readonly ReviewListFetcher $fetcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fetcher = static::getContainer()->get(ReviewListFetcher::class);
        ReviewTestFixtures::load($this->em);
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
