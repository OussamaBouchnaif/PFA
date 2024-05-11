<?php

namespace App\Repository;

use App\Entity\Camera;
use App\Service\Api\CallApiCameraService;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
  
    public function findCameraWithImages($idcamera)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c, i FROM App\Entity\Camera c
                 LEFT JOIN c.imageCameras i
                 WHERE c.id = :id'
            )
            ->setParameter('id', $idcamera)
            ->getOneOrNullResult();
    }
   
    public function findReductionsForCamera($cameraId)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r FROM App\Entity\Reduction r
                 JOIN r.ligneReductions lr
                 JOIN lr.camera c
                 WHERE c.id = :cameraId'
            )
            ->setParameter('cameraId', $cameraId)
            ->getOneOrNullResult();
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
