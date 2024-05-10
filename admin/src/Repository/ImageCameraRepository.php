<?php

namespace App\Repository;

use App\Entity\ImageCamera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageCamera>
 *
 * @method ImageCamera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageCamera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageCamera[]    findAll()
 * @method ImageCamera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageCameraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageCamera::class);
    }

    //    /**
    //     * @return ImageCamera[] Returns an array of ImageCamera objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ImageCamera
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
