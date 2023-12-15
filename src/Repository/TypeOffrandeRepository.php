<?php

namespace App\Repository;

use App\Entity\TypeOffrande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeOffrande>
 *
 * @method TypeOffrande|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOffrande|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOffrande[]    findAll()
 * @method TypeOffrande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOffrandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOffrande::class);
    }

//    /**
//     * @return TypeOffrande[] Returns an array of TypeOffrande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeOffrande
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
