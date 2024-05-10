<?php

namespace App\Services;

use App\Entity\Camera;
use app\Entity\ImageCamera;
use Doctrine\ORM\EntityManagerInterface;
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

    public function addCamera(Camera $camera, ImageCamera $imageCamera)
    {
        $entityManager = $this->entityManager;

        $entityManager->persist($imageCamera);
        $entityManager->persist($camera);
        $entityManager->flush();
    }

    public function editCamera(Camera $camera, ImageCamera $imageCamera)
    {
        $entityManager = $this->entityManager;

        // Attribuer la caméra à l'entité ImageCamera
        $imageCamera->setCamera($camera);

        // Persistez les modifications
        $entityManager->persist($imageCamera);
        $entityManager->flush();
    }
}
