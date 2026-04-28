<?php

declare(strict_types=1);

namespace App\Pagination;

interface PaginationInterface
{
    public function getOffset(): int;
    public function getTotalPages(): int;
    public function getPage(): int;
    public function getPerPage(): int;
}