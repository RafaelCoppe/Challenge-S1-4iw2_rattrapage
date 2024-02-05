<?php

namespace App\Repository;

use App\Entity\LigneStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneStatus>
 *
 * @method LigneStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneStatus[]    findAll()
 * @method LigneStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneStatus::class);
    }

//    /**
//     * @return LigneStatus[] Returns an array of LigneStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneStatus
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
