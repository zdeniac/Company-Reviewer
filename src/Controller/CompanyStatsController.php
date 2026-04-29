<?php

declare(strict_types=1);

namespace App\Controller;

use App\Stats\CompanyRatingStatsFetcher;
use App\Stats\CompanyStatsCsvExporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CompanyStatsController extends AbstractController
{
    #[Route('/companies/{page}', name: 'company_stats.index', methods: ['GET'])]
    public function index(CompanyRatingStatsFetcher $companyStats, int $page = 1): Response
    {
        $stats = $companyStats->getPaginated($page);
        return $this->render('company_stats/index.html.twig', [
            'stats' => $stats->getItems(),
            'pagination' => $stats->getPagination()
        ]);
    }

    #[Route('/export-companies', name: 'company_stats.export', methods: ['GET'])]
    public function export(CompanyStatsCsvExporter $exporter): Response
    {
        $response = $exporter->export();

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="company-stats.csv"'
        );

        return $response;
    }
}
