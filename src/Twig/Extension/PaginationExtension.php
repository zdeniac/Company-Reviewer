<?php

namespace App\Twig\Extension;

use App\Pagination\PaginationInterface;
use App\Pagination\PaginationRenderer;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PaginationExtension extends AbstractExtension
{
    public function __construct(
        private PaginationRenderer $renderer,
        private Environment $twig,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'render_pagination',
                [$this, 'render'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function render(PaginationInterface $pagination, string $route, array $params = []): string
    {
        return $this->twig->render('components/pagination.html.twig', [
            'pages' => $this->renderer->createView($pagination, $route, $params),
        ]);
    }
}
