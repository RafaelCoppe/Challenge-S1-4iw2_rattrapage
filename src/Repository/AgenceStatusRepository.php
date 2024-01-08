<?php

namespace App\Repository;

use App\Entity\AgenceStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgenceStatus>
 *
 * @method AgenceStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenceStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenceStatus[]    findAll()
 * @method AgenceStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenceStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgenceStatus::class);
    }

//    /**
//     * @return AgenceStatus[] Returns an array of AgenceStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AgenceStatus
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
