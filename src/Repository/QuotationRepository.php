<?php

namespace App\Repository;

use App\Entity\Invoice;
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
  
    public function findQuotesByAgencyAndNoInvoice($agency_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select * from quotation q                               
            where agency_id = :id_agency and invoice_id is null;
            ';

        $resultSet = $conn->executeQuery($sql, ['id_agency' => $agency_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findLatestQuotationsWithClientNames($agency_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select q.id, q.ref, c.firstname, c.lastname, q.status from quotation q 
            join client c on c.id = q.client_id                                 
            where q.agency_id = :id_agency;
            ';

        $resultSet = $conn->executeQuery($sql, ['id_agency' => $agency_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}

