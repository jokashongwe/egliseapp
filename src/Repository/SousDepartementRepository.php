<?php

namespace App\Repository;

use App\Entity\SousDepartement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SousDepartement>
 *
 * @method SousDepartement|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousDepartement|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousDepartement[]    findAll()
 * @method SousDepartement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousDepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousDepartement::class);
    }

//    /**
//     * @return SousDepartement[] Returns an array of SousDepartement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SousDepartement
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
