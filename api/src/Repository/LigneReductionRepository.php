<?php

namespace App\Repository;

use App\Entity\LigneReduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneReduction>
 *
 * @method LigneReduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneReduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneReduction[]    findAll()
 * @method LigneReduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneReductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneReduction::class);
    }

//    /**
//     * @return LigneReduction[] Returns an array of LigneReduction objects
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

//    public function findOneBySomeField($value): ?LigneReduction
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
