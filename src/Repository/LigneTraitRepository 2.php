<?php

namespace App\Repository;

use App\Entity\LigneTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneTrait>
 *
 * @method LigneTrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneTrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneTrait[]    findAll()
 * @method LigneTrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneTraitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneTrait::class);
    }

//    /**
//     * @return LigneTrait[] Returns an array of LigneTrait objects
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

//    public function findOneBySomeField($value): ?LigneTrait
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
