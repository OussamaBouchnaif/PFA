<?php

namespace App\Repository;

use App\Entity\Camera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

class CameraRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Camera::class);
        $this->paginator = $paginator;
    }

    /**
     * Get paginated cameras.
     *
     * @param int $page
     * @param int $limit
     * @return PaginationInterface
     */
    public function findPaginatedCameras(int $page = 1, int $limit = 10): PaginationInterface
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC');

        return $this->getPaginator()->paginate(
            $queryBuilder,
            $page,
            $limit
        );
    }

    private function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
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
