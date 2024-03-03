<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoice>
 *
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function findByAgency($agency_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select invoice.* from invoice
            join quotation on invoice.id = quotation.invoice_id
            where agency_id = :id_agency
            ';

        $resultSet = $conn->executeQuery($sql, ['id_agency' => $agency_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findLatestInvoicesWithDetails($agency_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select i.id, payment_firstname, payment_lastname, q.terms from invoice i
            join quotation q on i.id = q.invoice_id
            where agency_id = :id_agency
            ORDER BY id DESC
            LIMIT 5
            ';

        $resultSet = $conn->executeQuery($sql, ['id_agency' => $agency_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function countAllInvoices($agency_id): array|bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select count(*) from invoice i
            join quotation q on i.id = q.invoice_id
            where agency_id = :id_agency
            ';

        $resultSet = $conn->executeQuery($sql, ['id_agency' => $agency_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
