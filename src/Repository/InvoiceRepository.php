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
//     * @return Invoice[] Returns an array of Invoice objects
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

//    public function findOneBySomeField($value): ?Invoice
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// public function countInvoicesForCurrentMonth(): int
//     {
//         $currentMonth = (new \DateTime())->format('m'); // Obtenez le mois en cours au format 'm'

//         $entityManager = $this->getEntityManager();
//         $connection = $entityManager->getConnection();

//         $sql = 'SELECT COUNT(id) 
//                 FROM invoice 
//                 WHERE MONTH(date) = :currentMonth';

//         $statement = $connection->prepare($sql);
//         $statement->bindValue('currentMonth', $currentMonth);
//         $statement->execute();

//         return (int)$statement->fetchColumn();
//     }

        public function findLatestInvoicesWithDetails(): array
        {
            return $this->createQueryBuilder('i')
                ->select('i.id', 'i.terms', 'i.payment_firstname', 'i.payment_lastname') // Ajoutez les champs nécessaires
                // ->orderBy('i.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
        }


        public function countAllInvoices(): int
        {
            return $this->createQueryBuilder('i')
                ->select('COUNT(i.id)') 
                ->getQuery()
                ->getSingleScalarResult();
        }
}
