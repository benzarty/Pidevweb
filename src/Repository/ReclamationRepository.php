<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    public function findAllRC(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager ->createQuery('SELECT r FROM App\Entity\Reclamation r WHERE r.msgA LIKE :msgA')
            ->setParameter('msgA','%ACORBEILLE');
        return $query->getResult(); }

    public function findAllURC(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager ->createQuery('SELECT r FROM App\Entity\Reclamation r WHERE r.msg LIKE :msg')
            ->setParameter('msg','%UCORBEILLE');
        return $query->getResult(); }


    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function NotifCount(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('SELECT count(r) FROM App\Entity\Reclamation r WHERE r.exp <> :exp')
->setParameter('exp','ADMIN');
return $query->getSingleScalarResult(); }


    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    function UNotifCount($idu)
    {
        return $this->createQueryBuilder('r')
            ->select('count(r)')
            ->where('r.exp LIKE :exp')
            ->setParameter('exp','ADMIN')
            ->andWhere('r.idUser = :idu')
            ->setParameter('idu',$idu)
            ->getQuery()
            ->getSingleScalarResult();
    }


}
