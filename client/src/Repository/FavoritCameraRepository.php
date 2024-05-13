<?php

namespace App\Repository;

use App\Entity\Camera;
use App\Entity\Client;
use App\Entity\FavoritCamera;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    public function addToWishlist(Camera $camera,Client $client)
    {
        $favorit = new FavoritCamera();
        $favorit->setCamera($camera);
        $favorit->setClient($client);
        $this->doSave($favorit,true);
    }

    private function doSave($object,bool $isPersist = false):void
    {
        $manager = $this->getEntityManager();
        if(true === $isPersist)
        {
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function wishList(Client $client)
    {
        return $this->createQueryBuilder('fc') 
            ->select('c, fc,im') 
            ->innerJoin('fc.camera', 'c') 
            ->innerJoin('c.imageCameras','im')
            ->where('fc.client = :client') 
            ->setParameter('client', $client) 
            ->getQuery() 
            ->getResult(); 
    }
    public function countUserWishlistItems(Client $user)
    {
        return $this->createQueryBuilder('f')
            ->select('count(f.id)')
            ->where('f.client = :client')
            ->setParameter('client', $user)
            ->getQuery()
            ->getSingleScalarResult();
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
