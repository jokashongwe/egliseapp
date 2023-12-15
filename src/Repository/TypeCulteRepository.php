<?php

namespace App\Repository;

use App\Entity\TypeCulte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeCulte>
 *
 * @method TypeCulte|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCulte|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCulte[]    findAll()
 * @method TypeCulte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCulteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCulte::class);
    }

//    /**
//     * @return TypeCulte[] Returns an array of TypeCulte objects
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

//    public function findOneBySomeField($value): ?TypeCulte
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
