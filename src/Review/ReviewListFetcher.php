<?php

declare(strict_types=1);

namespace App\Review;

use App\Pagination\PaginatedListResult;
use App\Pagination\PaginationFactory;
use App\Repository\ReviewRepository;

final class ReviewListFetcher
{
    public function __construct(
        private readonly PaginationFactory $paginationFactory,
        private readonly ReviewRepository $repository,
    ) {
    }

    public function getPaginated(int $page, int $perPage = 10, ?string $companyName = null): PaginatedListResult
    {
        $pagination = $this->paginationFactory->create($page, $perPage, $this->repository->countFiltered($companyName));
        $items = $this->repository->findPaginated($pagination->getOffset(), $perPage, $companyName);

        return new PaginatedListResult($items, $pagination);
    }
}
