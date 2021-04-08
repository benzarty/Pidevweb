<?php

namespace App\Repository;

use App\Entity\Apprenant2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apprenant2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apprenant2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apprenant2[]    findAll()
 * @method Apprenant2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Apprenant2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apprenant2::class);
    }

    // /**
    //  * @return Apprenant2[] Returns an array of Apprenant2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Apprenant2
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
