<?php

namespace App\Repository;

use App\Entity\Camera;
<<<<<<< HEAD
<<<<<<< HEAD
use App\Service\Api\CallApiCameraService;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
=======
=======
use App\Service\Api\CallApiCameraService;
>>>>>>> 44d6728 (adapt api's pagination)
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
<<<<<<< HEAD
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
=======
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
>>>>>>> 44d6728 (adapt api's pagination)

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
<<<<<<< HEAD
   private CallApiCameraService $callapi;

    public function __construct(ManagerRegistry $registry,CallApiCameraService $callapi)
    {
        parent::__construct($registry, Camera::class);
        $this->callapi = $callapi;   
        
=======
    public function __construct(ManagerRegistry $registry)
=======
   private CallApiCameraService $callapi;

    public function __construct(ManagerRegistry $registry,CallApiCameraService $callapi)
>>>>>>> 44d6728 (adapt api's pagination)
    {
        parent::__construct($registry, Camera::class);
        $this->callapi = $callapi;   
        
    }
    public function extractPaginationInfo(int $page)
    {
<<<<<<< HEAD
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
=======
        
        $paginationInfo = [
            'totalPages' => ceil($this->callapi->getItems()/9),
            'currentPage' => $page,
        ];
    
        return $paginationInfo;
    }
    public function fillInTheSession($newCriteria,SessionInterface $session):array
    {
<<<<<<< HEAD
>>>>>>> 44d6728 (adapt api's pagination)
=======
        $searchCriteria = $session->get('searchCriteria', array());
>>>>>>> fa04ec1 (maintain search code)
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
<<<<<<< HEAD
<<<<<<< HEAD
        return $searchCriteria;
=======
>>>>>>> 44d6728 (adapt api's pagination)
=======
        return $searchCriteria;
>>>>>>> fa04ec1 (maintain search code)
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
