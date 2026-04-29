<?php

namespace App\Twig\Extension;

use App\Pagination\PaginationRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PaginationExtension extends AbstractExtension
{ 
    public function __construct(
        private PaginationRenderer $renderer
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'render_pagination',
                [$this->renderer, 'render'],
                ['is_safe' => ['html']]
            ),
        ];
    }
}
