<?php

declare(strict_types=1);

namespace App\Pagination;

readonly class Pagination implements PaginationInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(
        private int $page,
        private int $perPage,
        private int $totalItems,
    ) {
        if ($page < 1 || $perPage < 1) {
            throw new \InvalidArgumentException('page and perPage must be >= 1');
        }
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->totalItems / $this->perPage);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
