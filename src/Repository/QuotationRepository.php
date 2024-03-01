<?php

namespace App\Repository;

use App\Entity\Quotation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quotation>
 *
 * @method Quotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quotation[]    findAll()
 * @method Quotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quotation::class);
    }

//    /**
//     * @return Quotation[] Returns an array of Quotation objects
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

//    public function findOneBySomeField($value): ?Quotation
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findQuotationsByStatus($status)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }


    public function findLatestQuotationsWithClientNames(): array
    {
        return $this->createQueryBuilder('q')
            ->select('q.terms', 'q.status', 'q.ref', 'c.firstname', 'c.lastname') 
            ->join('q.client', 'c')
            ->orderBy('q.start_date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
