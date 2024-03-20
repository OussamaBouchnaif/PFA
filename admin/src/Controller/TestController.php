<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Form\PhotoType;
use App\Form\CameraType;
use App\Entity\ImageCamera;
use App\Repository\CameraRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ImageCameraRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
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

<<<<<<< HEAD
        if ($formCamera->isSubmitted()) {
=======
        // Vérification de la soumission du formulaire de la caméra
        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
            // Récupération des données du formulaire de la caméra
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
            $camera = $formCamera->getData();

            // Vérification de la soumission du formulaire de l'image
            if ($formImage->isSubmitted() && $formImage->isValid()) {
                // Récupération des données du formulaire de l'image
                $image = $formImage->getData();

<<<<<<< HEAD
            $image->setCamera($camera);
            $entityManager->persist($image);
=======
                // Association de l'image à la caméra
                $image->setCamera($camera);

                // Persist et flush de l'image
                $entityManager->persist($image);
            }

            // Persist et flush de la caméra
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
            $entityManager->persist($camera);
            $entityManager->flush();

            // Redirection avec un message flash
            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        }
<<<<<<< HEAD
        return $this->render('admin/Cameras/addProduct.html.twig', [

            'form' => $formCamera->createView(), 'formI' => $formImage->createView(),
=======

        // Affichage du formulaire
        return $this->render('admin/Cameras/addProduct.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView(),
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
        ]);
    }
}
