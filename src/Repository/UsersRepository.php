<?php

namespace App\Repository;

use App\Entity\Apprenant;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
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

    function SearchApprenant($nsc)
    {
        return $this->createQueryBuilder('s')
            ->where('s.nom LIKE :nom')
            ->setParameter('nom','%'.$nsc.'%')
            ->andWhere('s.role LIKE :apprenant')
            ->setParameter('apprenant','apprenant')
            ->getQuery()
            ->getResult();
    }
    function SearchProf($nsc)
    {
        return $this->createQueryBuilder('s')
            ->where('s.nom LIKE :nom')
            ->setParameter('nom','%'.$nsc.'%')
            ->andWhere('s.role LIKE :professeur')
            ->setParameter('professeur','professeur')
            ->getQuery()
            ->getResult();
    }
}
