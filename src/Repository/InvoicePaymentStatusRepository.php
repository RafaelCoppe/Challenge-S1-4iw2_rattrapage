<?php

namespace App\Repository;

use App\Entity\InvoicePaymentStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvoicePaymentStatus>
 *
 * @method InvoicePaymentStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoicePaymentStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoicePaymentStatus[]    findAll()
 * @method InvoicePaymentStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoicePaymentStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoicePaymentStatus::class);
    }

//    /**
//     * @return InvoicePaymentStatus[] Returns an array of InvoicePaymentStatus objects
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

//    public function findOneBySomeField($value): ?InvoicePaymentStatus
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
