<?php

namespace App\Repository;

use App\Entity\Internships;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Internships>
 */
class InternshipsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Internships::class);
    }

     /**
     * Get all the intersnships by creation date
     */

       /**
        * @return Internships[] Returns by date
        */
       public function findAllOrderedByDate(): array
       {
           return $this->createQueryBuilder('internship')
               ->orderBy('internship.dateTime', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Internships
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
