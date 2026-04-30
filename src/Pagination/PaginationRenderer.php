<?php

declare(strict_types=1);

namespace App\Pagination;

use Symfony\Component\Routing\RouterInterface;

final class PaginationRenderer
{
    public function __construct(
        private RouterInterface $router
    ) {
    }

    public function createView(PaginationInterface $pagination, string $route, array $params = []): array
    {
        $pages = [];

        for ($i = 1; $i <= $pagination->getTotalPages(); $i++) {
            $pages[] = [
                'number' => $i,
                'url' => $this->router->generate($route, array_merge($params, ['page' => $i])),
                'active' => $i === $pagination->getPage(),
            ];
        }

        return $pages;
    }
}
