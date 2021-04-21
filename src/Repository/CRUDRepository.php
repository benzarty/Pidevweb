<?php

namespace App\Repository;

use App\Entity\CRUD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CRUD|null find($id, $lockMode = null, $lockVersion = null)
 * @method CRUD|null findOneBy(array $criteria, array $orderBy = null)
 * @method CRUD[]    findAll()
 * @method CRUD[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CRUDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CRUD::class);
    }

    // /**
    //  * @return CRUD[] Returns an array of CRUD objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CRUD
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
