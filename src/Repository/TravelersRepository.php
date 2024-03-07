<?php

namespace App\Repository;

use App\Entity\Travelers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Travelers>
 *
 * @method Travelers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travelers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travelers[]    findAll()
 * @method Travelers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravelersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travelers::class);
    }

//    /**
//     * @return Travelers[] Returns an array of Travelers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Travelers
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
