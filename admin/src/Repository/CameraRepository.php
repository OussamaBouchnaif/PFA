<?php

namespace App\Repository;

use App\Entity\Camera;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class CameraRepository extends ServiceEntityRepository
{
    private $entityManager; // Déclarez la propriété $entityManager

    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, EntityManagerInterface $entityManager) // Injectez EntityManagerInterface dans le constructeur
    {
        parent::__construct($registry, Camera::class);
        $this->entityManager = $entityManager; // Assignez l'EntityManagerInterface à la propriété $entityManager
        $this->paginator = $paginator;
    }

    /**
     * Get paginated cameras.
     *
     * @return PaginationInterface
     */
    public function getCamerasByCategory(): array
    {
        $categorieRepository = $this->entityManager->getRepository(Categorie::class);

        $categoriesWithCameraCount = $categorieRepository->createQueryBuilder('c')
            ->select('c.nom as category_name', 'COUNT(ca.id) as camera_count')
            ->leftJoin('c.cameras', 'ca')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();

        $categoriesData = [];
        foreach ($categoriesWithCameraCount as $data) {
            $categoriesData[$data['category_name']] = $data['camera_count'];
        }

        return $categoriesData;
    }
    

}
