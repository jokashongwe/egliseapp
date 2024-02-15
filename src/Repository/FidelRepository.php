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

            WHERE (f.deces =  0 or f.deces is null)
            
             AND (f.supprimer =  0 or f.supprimer is null)
            
        ');

        return $query->getSingleResult();
    }

    public function NbrMembreOuvrier()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT COUNT(1)
            FROM Fidel f,Departement d ,Sous_Departement s

            WHERE s.id=f.Sousdepartement AND f.departement_id=d.id AND (f.deces =  0 or f.deces is null)
            
             AND (f.supprimer =  0 or f.supprimer is null)
             AND (f.Sousdepartement <>  0 or f.departement_id is not null)
             AND (f.Sousdepartement is not  null or f.departement_id <> 0)
        ');

        return $query->getSingleResult();
    }
    public function countMembreBySexe()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT f.sexe, count(1) as Nbr
            FROM App\Entity\Fidel f

            WHERE (f.deces =  0 or f.deces is null)
            
             AND (f.supprimer =  0 or f.supprimer is null)
            
            GROUP BY f.sexe
        ');
        return $query->getResult();
    }

    public function countMembreBySexeOuvrier()
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->select('f.sexe', 'COUNT(1) as Nbr')
            ->where('f.deces = 0 OR f.deces IS NULL')
            ->andWhere('f.supprimer = 0 OR f.supprimer IS NULL')
            ->andWhere('f.departement > 0')
            ->groupBy('f.sexe');

        return $queryBuilder->getQuery()->getResult();
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
    public function countByCategorieOuvrier()
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->select('f.categorie', 'COUNT(1) AS nbr')
            ->where('f.deces = 0 OR f.deces IS NULL')
            ->andWhere('f.supprimer = 0 OR f.supprimer IS NULL')
            ->andWhere('f.departement > 0')
            ->groupBy('f.categorie');

        return $queryBuilder->getQuery()->getResult();
    }

    public function findbyRecherche($value)
    {
        $entityManager = $this->getEntityManager();

        $value = str_replace(" ", "%", $value);
        $value = strtolower($value);

        $query = $entityManager->createQuery('
            SELECT f
            FROM App\Entity\Fidel f
            WHERE (LOWER(f.nom) like :value OR LOWER(f.postnom) like :value OR LOWER(f.prenom) like :value)
                AND f.supprimer = 0
                AND f.deces = 0 
               
        ')
            ->setParameter('value', "%" . $value . "%");


        return $query->getResult();
    }


    public function findByValueStatistiquetotal()
    {
        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare("

        SELECT  COUNT(f.id) as total from fidel f WHERE f.supprimer = 0
        AND f.deces = 0 
        ");


        $result = $stmt->executeQuery();


        return $result->fetchAllAssociative();
    }
}
