<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findPaginated(int $offset, int $perPage, ?string $companyName = null): array
    {
        $qb = $this->createQueryBuilder('r')
            ->setFirstResult($offset)
            ->setMaxResults($perPage);

        if (null !== $companyName) {
            $qb->andWhere('r.companyName LIKE :companyName')
                ->setParameter('companyName', '%'.$companyName.'%');
        }

        return $qb
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

    public function countFiltered(?string $companyName = null): int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('COUNT(r.id)');

        if (null !== $companyName) {
            $qb->andWhere('r.companyName LIKE :companyName')
            ->setParameter('companyName', '%'.$companyName.'%');
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countCompanies(): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(DISTINCT r.companyName)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getRatingsByCompaniesPaginated(int $offset, int $perPage): array
    {
        return $this->createCompanyStatsQueryBuilder()
            ->setFirstResult($offset)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getArrayResult();
    }

    public function getRatingsByCompanies(): array
    {
        return $this->createCompanyStatsQueryBuilder()
            ->getQuery()
            ->getArrayResult();
    }

    private function createCompanyStatsQueryBuilder()
    {
        return $this->createQueryBuilder('r')
            ->select('r.companyName AS companyName')
            ->addSelect('COUNT(r.id) AS reviewNum')
            ->addSelect('AVG(r.rating) AS averageRating')
            ->groupBy('r.companyName')
            ->orderBy('averageRating', 'DESC');
    }
}
