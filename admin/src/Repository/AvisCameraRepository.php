<?php

namespace App\Repository;

use App\Entity\AvisCamera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AvisCamera>
 *
 * @method AvisCamera|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvisCamera|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvisCamera[]    findAll()
 * @method AvisCamera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisCameraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvisCamera::class);
    }

    //    /**
    //     * @return AvisCamera[] Returns an array of AvisCamera objects
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

    //    public function findOneBySomeField($value): ?AvisCamera
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
