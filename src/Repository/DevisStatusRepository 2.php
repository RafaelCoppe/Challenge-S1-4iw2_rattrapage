<?php

namespace App\Repository;

use App\Entity\DevisStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DevisStatus>
 *
 * @method DevisStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisStatus[]    findAll()
 * @method DevisStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevisStatus::class);
    }

//    /**
//     * @return DevisStatus[] Returns an array of DevisStatus objects
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

//    public function findOneBySomeField($value): ?DevisStatus
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
