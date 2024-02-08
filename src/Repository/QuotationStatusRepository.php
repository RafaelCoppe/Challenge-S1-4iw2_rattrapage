<?php

namespace App\Repository;

use App\Entity\QuotationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuotationStatus>
 *
 * @method QuotationStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuotationStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuotationStatus[]    findAll()
 * @method QuotationStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotationStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuotationStatus::class);
    }

//    /**
//     * @return QuotationStatus[] Returns an array of QuotationStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuotationStatus
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
