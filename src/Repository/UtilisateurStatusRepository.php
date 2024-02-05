<?php

namespace App\Repository;

use App\Entity\UtilisateurStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UtilisateurStatus>
 *
 * @method UtilisateurStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UtilisateurStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UtilisateurStatus[]    findAll()
 * @method UtilisateurStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UtilisateurStatus::class);
    }

//    /**
//     * @return UtilisateurStatus[] Returns an array of UtilisateurStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UtilisateurStatus
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
