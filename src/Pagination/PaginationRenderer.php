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

    public function render(PaginationInterface $pagination, string $route, array $params = []): string
    {
        $html = '<ul>';

        for ($i = 1; $i <= $pagination->getTotalPages(); $i++) {
            $query = array_merge($params, ['page' => $i]);

            $url = $this->router->generate($route, $query);

            $html .= sprintf(
                '<li><a href="%s">%d</a></li>',
                $url,
                $i
            );
        }

        $html .= '</ul>';

        return $html;
    }
}