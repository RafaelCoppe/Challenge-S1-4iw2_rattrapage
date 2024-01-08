<?php

namespace App\Repository;

use App\Entity\FacturePaymentStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacturePaymentStatus>
 *
 * @method FacturePaymentStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacturePaymentStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacturePaymentStatus[]    findAll()
 * @method FacturePaymentStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturePaymentStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacturePaymentStatus::class);
    }

//    /**
//     * @return FacturePaymentStatus[] Returns an array of FacturePaymentStatus objects
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

//    public function findOneBySomeField($value): ?FacturePaymentStatus
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
