<?php

namespace App\Services;
use App\Entity\Camera;
use app\Entity\ImageCamera;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class CameraModel
{
    private $entityManager;
    private $urlGenerator;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }

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
    public function addCamera(Camera $camera, ImageCamera $imageCamera): JsonResponse
    {
        $entityManager = $this->entityManager;

        $entityManager->persist($imageCamera);
        $entityManager->persist($camera);
        $entityManager->flush();

        // Générer l'URL de redirection vers la page de la liste des caméras
        $redirectUrl = $this->urlGenerator->generate('camera');

        return new JsonResponse(['redirect_url' => $redirectUrl]);
    }

    public function editCamera(Camera $camera, ImageCamera $imageCamera, Request $request): JsonResponse
    {
        $entityManager = $this->entityManager;

        // Attribuer la caméra à l'entité ImageCamera
        $imageCamera->setCamera($camera);

        // Persistez les modifications
        $entityManager->persist($imageCamera);
        $entityManager->flush();

        $redirectUrl = $this->urlGenerator->generate('camera');

        return new JsonResponse(['redirect_url' => $redirectUrl]);
    }


    
}
