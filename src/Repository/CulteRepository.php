<?php

namespace App\Repository;

use App\Entity\Culte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Culte>
 *
 * @method Culte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Culte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Culte[]    findAll()
 * @method Culte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CulteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Culte::class);
    }

//    /**
//     * @return Culte[] Returns an array of Culte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Culte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
