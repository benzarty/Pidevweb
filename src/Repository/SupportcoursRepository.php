<?php

namespace App\Repository;

use App\Entity\Supportcours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supportcours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supportcours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supportcours[]    findAll()
 * @method Supportcours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportcoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supportcours::class);
    }

    // /**
    //  * @return Supportcours[] Returns an array of Supportcours objects
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
    public function findOneBySomeField($value): ?Supportcours
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