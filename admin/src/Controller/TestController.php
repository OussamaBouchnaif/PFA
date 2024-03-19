<?php
namespace App\Controller;

use App\Entity\Camera;
use App\Form\CameraType;
use App\Entity\ImageCamera;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/Addtest', name: 'addtest')]
    public function addCamera(Request $request, EntityManagerInterface $entityManager): Response
    {
        $camera = new Camera();
        $imageCamera = new ImageCamera();

        // Création des formulaires
        $formCamera = $this->createForm(CameraType::class, $camera);
        $formImage = $this->createForm(PhotoType::class, $imageCamera);

        // Gestion de la requête
        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);

        // Vérification de la soumission du formulaire de la caméra
        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
            // Récupération des données du formulaire de la caméra
            $camera = $formCamera->getData();

            // Vérification de la soumission du formulaire de l'image
            if ($formImage->isSubmitted() && $formImage->isValid()) {
                // Récupération des données du formulaire de l'image
                $image = $formImage->getData();

                // Association de l'image à la caméra
                $image->setCamera($camera);

                // Persist de l'image
                $entityManager->persist($image);
            }

            // Persist de la caméra
            $entityManager->persist($camera);
            $entityManager->flush();

            // Redirection avec un message flash
            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        }

        // Affichage du formulaire
        return $this->render('admin/Cameras/addProduct.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView(),
        ]);
    }
}
