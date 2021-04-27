<?php

namespace App\Repository;


use App\Entity\Emploidetemps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Emploidetemps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emploidetemps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emploidetemps[]    findAll()
 * @method Emploidetemps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmploidetempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emploidetemps::class);
    }

    // /**
    //  * @return Apprenant[] Returns an array of Apprenant objects
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
    public function findOneBySomeField($value): ?Apprenant
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
