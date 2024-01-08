<?php

namespace App\Repository;

use App\Entity\AgenceDomaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgenceDomaine>
 *
 * @method AgenceDomaine|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenceDomaine|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenceDomaine[]    findAll()
 * @method AgenceDomaine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenceDomaineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgenceDomaine::class);
    }

//    /**
//     * @return AgenceDomaine[] Returns an array of AgenceDomaine objects
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

//    public function findOneBySomeField($value): ?AgenceDomaine
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
