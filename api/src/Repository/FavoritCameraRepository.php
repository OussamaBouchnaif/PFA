<?php

namespace App\Repository;

use App\Entity\FavoritCamera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavoritCamera>
 *
 * @method FavoritCamera|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoritCamera|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoritCamera[]    findAll()
 * @method FavoritCamera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoritCameraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoritCamera::class);
    }

//    /**
//     * @return FavoritCamera[] Returns an array of FavoritCamera objects
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

//    public function findOneBySomeField($value): ?FavoritCamera
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
