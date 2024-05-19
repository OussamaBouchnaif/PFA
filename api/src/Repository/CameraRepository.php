<?php

namespace App\Repository;

use App\Entity\Camera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
/**
 * @extends ServiceEntityRepository<Camera>
 *
 * @method Camera|null find($id, $lockMode = null, $lockVersion = null)
 * @method Camera|null findOneBy(array $criteria, array $orderBy = null)
 * @method Camera[]    findAll()
 * @method Camera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CameraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camera::class);
    }


    public function findLastCameras()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.dateAjout', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();  
    }

    public function findCamerasSameCategoryAsCameraId(int $cameraId)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM App\Entity\Camera c
                 JOIN c.categorie cat
                 WHERE cat.id = (
                     SELECT cat2.id FROM App\Entity\Camera c2
                     JOIN c2.categorie cat2
                     WHERE c2.id = :cameraId
                 )
                 AND c.id != :cameraId'
            )
            ->setParameter('cameraId', $cameraId)
            ->getResult();
    }
    
    

    //    /**
    //     * @return Camera[] Returns an array of Camera objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Camera
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
