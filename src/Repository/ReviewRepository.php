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

        if ($companyName !== null) {
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

        if ($companyName !== null) {
            $qb->andWhere('r.companyName LIKE :companyName')
            ->setParameter('companyName', '%'.$companyName.'%');
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
