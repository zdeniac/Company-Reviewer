<?php

declare(strict_types=1);

namespace App\Pagination;

final readonly class PaginatedListResult
{
    public function __construct(
        private array $items,
        private PaginationInterface $pagination
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
