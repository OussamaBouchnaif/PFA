<?php


namespace App\Controller;

use App\Entity\AvisCamera;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $avisRepository = $entityManager->getRepository(AvisCamera::class);
        $avis_list = $avisRepository->findAll();

        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
            'avis_list' => $avis_list,
        ]);
    }

    #[Route('/avis/delete/{id}', name: 'app_avis_delete')]
    public function delete(AvisCamera $avis, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($avis);
            $entityManager->flush();

            $this->addFlash('success', 'L\'avis a été supprimé avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite lors de la suppression de l\'avis.');
        }

        return $this->redirectToRoute('app_avis');
    }
}
