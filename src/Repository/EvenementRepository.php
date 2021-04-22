<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public  function evenementProhain(){
        $requette = "SELECT Id_evenement as idEvenement, lien, theme, date_evenement as dateEvenement, presentateur, image from evenement where date_evenement > CURRENT_DATE ;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

    public  function evenementAujourdhui(){
        $requette = "SELECT Id_evenement as idEvenement, lien, theme, date_evenement as dateEvenement, presentateur, image from evenement where date_evenement = CURRENT_DATE ;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

    public  function evenementDate($date){
        $requette = "SELECT Id_evenement as idEvenement, lien, theme, date_evenement as dateEvenement, presentateur, image from evenement where date_evenement  = $date;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }
    public  function evenementSemaine(){
        $requette = "SELECT Id_evenement as idEvenement, lien, theme, date_evenement as dateEvenement, presentateur, image from evenement where date_evenement BETWEEN CURRENT_DATE AND adddate(CURRENT_DATE,7);";
        $stmt = $this->getEntityManager()->getConnection()->prepare($requette);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }



    // /**
    //  * @return Evenement[] Returns an array of Evenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
