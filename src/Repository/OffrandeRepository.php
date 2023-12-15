<?php

namespace App\Repository;

use App\Entity\Offrande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offrande>
 *
 * @method Offrande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offrande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offrande[]    findAll()
 * @method Offrande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffrandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offrande::class);
    }

//    /**
//     * @return Offrande[] Returns an array of Offrande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offrande
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
