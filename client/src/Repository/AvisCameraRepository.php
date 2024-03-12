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
    private CameraRepository $camrepo;
    public function __construct(ManagerRegistry $registry,CameraRepository $camrepo)
    {
        parent::__construct($registry, AvisCamera::class);
        $this->camrepo =$camrepo;
    }



    public function addAvisCamera(AvisCamera $avisCamera,$content,$id,$user)
    {
        $manager = $this->getEntityManager();
        $camera = $this->camrepo->findOneBy(['id'=>$id]);
        $avisCamera->setClient($user);
        $avisCamera->setCamera($camera);
        $avisCamera->setCommentaire($content);
        $avisCamera->setNote('5');
        $this->doSave($avisCamera,true);
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
