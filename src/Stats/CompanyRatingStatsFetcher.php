<?php

declare(strict_types=1);

namespace App\Stats;

use App\Pagination\PaginatedListResult;
use App\Pagination\PaginationFactory;
use App\Repository\ReviewRepository;

final readonly class CompanyRatingStatsFetcher
{
    public function __construct(
        private PaginationFactory $paginationFactory,
        private ReviewRepository $repository
    ) {
    }

    public function getPaginated(int $page, int $perPage = 10): PaginatedListResult
    {
        $pagination = $this->paginationFactory->create(
            $page, 
            $perPage,
            $this->repository->countCompanies()
        );

        $items = $this->repository->getRatingsByCompaniesPaginated($pagination->getOffset(), $perPage);

        return new PaginatedListResult($items, $pagination);
    }
}