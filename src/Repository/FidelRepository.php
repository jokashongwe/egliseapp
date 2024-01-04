<?php

namespace App\Repository;

use App\Entity\Fidel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fidel>
 *
 * @method Fidel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fidel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fidel[]    findAll()
 * @method Fidel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FidelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fidel::class);
    }

    //    /**
    //     * @return Fidel[] Returns an array of Fidel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fidel
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function NbrMembre()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT COUNT(1)
            FROM App\Entity\Fidel f
            
        ');

        return $query->getSingleResult();
    }
    public function countMembreBySexe()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT f.sexe, count(1) as Nbr
            FROM App\Entity\Fidel f
            
            GROUP BY f.sexe
        ');
        return $query->getResult();
    }
    public function countBycategorie()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT
                f.categorie, COUNT(1) nbr
            FROM
                App\Entity\Fidel f
            WHERE (f.deces =  0 or f.deces is null)
            
             AND (f.supprimer =  0 or f.supprimer is null)
                
           
            GROUP BY f.categorie
        ');
        return $query->getResult();
    }
}
