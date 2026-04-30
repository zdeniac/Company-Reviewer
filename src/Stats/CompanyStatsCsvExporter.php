<?php

declare(strict_types=1);

namespace App\Stats;

use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class CompanyStatsCsvExporter
{
    public function __construct(
        private ReviewRepository $repository,
    ) {
    }

    public function export(): StreamedResponse
    {
        $data = $this->repository->getRatingsByCompanies();

        return new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');

            // header
            fputcsv($handle, ['Cégnév', 'Értékelések', 'Átlag']);

            foreach ($data as $row) {
                fputcsv($handle, [
                    $row['companyName'],
                    $row['reviewNum'],
                    $row['averageRating'],
                ]);
            }

            fclose($handle);
        });
    }
}
