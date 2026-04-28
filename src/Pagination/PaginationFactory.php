<?php

declare(strict_types=1);

namespace App\Pagination;

final class PaginationFactory
{
    public function create(int $page, int $perPage, int $total): Pagination
    {
        return new Pagination($page, $perPage, $total);
    }
}