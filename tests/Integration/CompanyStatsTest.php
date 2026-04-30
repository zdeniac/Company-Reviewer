<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Entity\Review;
use App\Tests\DataFixtures\ReviewTestFixtures;

class CompanyStatsTest extends AbstractDatabaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ReviewTestFixtures::load($this->em);
    }

    public function testAggregationAndSorting(): void
    {
        $repo = $this->em->getRepository(Review::class);

        $results = $repo->getRatingsByCompanies();

        // 2 külön cég
        $this->assertCount(2, $results);

        // Apple: (5 + 4) / 2 = 4.5
        // Google: 3

        // rendezés (DESC)
        $this->assertSame('Apple', $results[0]['companyName']);
        $this->assertSame('Google', $results[1]['companyName']);

        // átlag
        $this->assertEquals(4.5, (float) $results[0]['averageRating']);
        $this->assertEquals(3.0, (float) $results[1]['averageRating']);

        // darabszám
        $this->assertSame(2, (int) $results[0]['reviewNum']);
        $this->assertSame(1, (int) $results[1]['reviewNum']);
    }
}
