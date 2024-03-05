<?php

namespace App\Repository;

use App\Entity\Camera;
<<<<<<< HEAD
use App\Service\Api\CallApiCameraService;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
=======
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)

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
   
<<<<<<< HEAD
   private CallApiCameraService $callapi;

    public function __construct(ManagerRegistry $registry,CallApiCameraService $callapi)
    {
        parent::__construct($registry, Camera::class);
        $this->callapi = $callapi;   
        
=======
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camera::class);
    
    }

    public function getPagination($camera,PaginatorInterface $paginatorInterface,Request $request)
    {
        $data = $paginatorInterface->paginate(
            $camera,
            $request->query->getInt('page',1),
            9
        );
        return $data;
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
    }
    public function extractPaginationInfo(int $page)
    {
        
        $paginationInfo = [
            'totalPages' => ceil($this->callapi->getItems()/9),
            'currentPage' => $page,
        ];
    
        return $paginationInfo;
    }
    public function fillInTheSession($newCriteria,SessionInterface $session):array
    {
        $searchCriteria = $session->get('searchCriteria', array());
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
        return $searchCriteria;
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
