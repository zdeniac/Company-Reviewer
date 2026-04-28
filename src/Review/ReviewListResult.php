<?php

declare(strict_types=1);

namespace App\Review;

use App\Pagination\PaginationInterface;

final class ReviewListResult
{
    public function __construct(
        private readonly array $items = [],
        private readonly PaginationInterface $pagination
    ) {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }
}