<?php

namespace App\Repository;

use App\Entity\StarOfTheDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StarOfTheDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StarOfTheDay::class);
    }

    // Étoiles visibles AUJOURD’HUI
    public function findTodayStars(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date = :today')
            ->andWhere('s.visibleTonight = true')
            ->setParameter('today', new \DateTime('today'))
            ->getQuery()
            ->getResult();
    }
}
