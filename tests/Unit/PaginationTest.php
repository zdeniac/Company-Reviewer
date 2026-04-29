<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Pagination\Pagination;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    public function testConstructorThrowsExceptionWhenInvalidInput(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Pagination(0, 10, 100);
    }

    #[DataProvider('offsetProvider')]
    public function testGetOffset(int $page, int $perPage, int $expected): void
    {
        $pagination = new Pagination($page, $perPage, 1000);

        $this->assertSame($expected, $pagination->getOffset());
    }

    #[DataProvider('totalPagesProvider')]
    public function testGetTotalPages(int $totalItems, int $perPage, int $expected): void
    {
        $pagination = new Pagination(1, $perPage, $totalItems);

        $this->assertSame($expected, $pagination->getTotalPages());
    }

    public static function offsetProvider(): array
    {
        return [
            'page 1' => [1, 10, 0],
            'page 2' => [2, 10, 10],
            'page 3' => [3, 10, 20],
            'page 5, perPage 25' => [5, 25, 100],
        ];
    }

    public static function totalPagesProvider(): array
    {
        return [
            'exact division' => [100, 10, 10],
            'round up' => [95, 10, 10],
            'small dataset' => [1, 10, 1],
            'not divisible' => [101, 10, 11],
        ];
    }
}
