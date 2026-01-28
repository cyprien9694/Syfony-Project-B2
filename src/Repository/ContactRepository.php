<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    // Exemple futur :
    // public function findLatest(): array
    // {
    //     return $this->createQueryBuilder('c')
    //         ->orderBy('c.created_at', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }
}
