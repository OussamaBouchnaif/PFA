<?php

namespace App\Controller;

use App\Entity\AvisCamera; // Import pour AvisCamera
use Doctrine\ORM\EntityManagerInterface; // Import pour EntityManagerInterface
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les avis depuis la base de données
        $avisRepository = $entityManager->getRepository(AvisCamera::class);
        $avis_list = $avisRepository->findAll();

        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
            'avis_list' => $avis_list, // Utilisez "avis_list" pour correspondre au modèle Twig
        ]);
    }
}
