<?php

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }


    public  function promotionWithApPr(){
        $requette = "SELECT p1.id_promotion, p1.promotion, p1.raison_promotion,p1.date_promotion,p2.nom as nomAp,p2.prenom as prenomAp,p2.photo as photoAp, p3.nom,p3.prenom,p3.photo
                    FROM promotion as p1, apprenant as p2, professeur as p3
                    WHERE p1.id_apprenant = p2.id_apprenant AND p1.id_professeur = p3.Id_professeur;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }



    public  function promotionMois(){
        $requette = "SELECT p1.id_promotion, p1.promotion, p1.raison_promotion,p1.date_promotion,p2.nom as nomAp,p2.prenom as prenomAp,p2.photo as photoAp, p3.nom,p3.prenom,p3.photo
                    FROM promotion as p1, apprenant as p2, professeur as p3
                    WHERE p1.id_apprenant = p2.id_apprenant AND p1.id_professeur = p3.Id_professeur AND month(p1.date_promotion) = month(CURRENT_DATE);";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

    public  function Top5Promo(){
        $requette = "SELECT p1.id_promotion, p1.promotion, p1.raison_promotion,p1.date_promotion,p2.nom as nomAp,p2.prenom as prenomAp,p2.photo as photoAp, p3.nom,p3.prenom,p3.photo
                    FROM promotion as p1, apprenant as p2, professeur as p3
                    WHERE p1.id_apprenant = p2.id_apprenant AND p1.id_professeur = p3.Id_professeur order by p1.date_promotion limit 5;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }
    public function promotionPromo($promo){

        $requette = "SELECT p1.id_promotion, p1.promotion, p1.raison_promotion,p1.date_promotion,p2.nom as nomAp,p2.prenom as prenomAp,p2.photo as photoAp, p3.nom,p3.prenom,p3.photo
                    FROM promotion as p1, apprenant as p2, professeur as p3
                    WHERE p1.id_apprenant = p2.id_apprenant AND p1.id_professeur = p3.Id_professeur and p2.nom like '%'$promo'%'  or p3.nom LIKE '%'$promo'%'";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();

    }



    // /**
    //  * @return Promotion[] Returns an array of Promotion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promotion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
