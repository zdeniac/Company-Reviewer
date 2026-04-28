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

    public function findPaginated(int $offset, int $perPage): array
    {
        return $this->createQueryBuilder('r')
            ->setFirstResult($offset)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getArrayResult();
    }
}
