<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findBySearchString(string $searchString, int $limit = null)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.givn LIKE :searchString')
            ->orWhere('p.surn LIKE :searchString')
            ->setParameter('searchString', "%$searchString%");
        if ($limit) {
            $qb->setMaxResults($limit);
        }
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function countBySearchString(string $searchString)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->where('p.givn LIKE :searchString')
            ->orWhere('p.surn LIKE :searchString')
            ->setParameter('searchString', "%$searchString%");
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }
}
