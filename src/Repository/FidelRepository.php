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
}
