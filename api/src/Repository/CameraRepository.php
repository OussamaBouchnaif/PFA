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

        // Requête pour obtenir l'ID de la catégorie du produit 65
      /*   $categoryId = $this->createQueryBuilder('c')
            ->select('c.category')
            ->from(Camera::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $cameraId)
            ->getQuery()
            ->getSingleScalarResult();

        // Requête pour obtenir tous les produits de la même catégorie
        return $this->createQueryBuilder()
            ->select('c')
            ->from(Camera::class, 'c')
            ->where('c.category = :category')
            ->setParameter('category', $categoryId)
            ->getQuery()
            ->getResult(); */
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
