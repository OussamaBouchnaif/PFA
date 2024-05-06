<?php
// src/Controller/TestController.php

namespace App\Controller;

use App\Entity\Camera;
use App\Entity\ImageCamera;
use App\Form\CameraType;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/addtest', name: 'addtest')]
    public function addCamera(Request $request, EntityManagerInterface $entityManager): Response
    {
        $camera = new Camera();
        $imageCamera = new ImageCamera();

        $formCamera = $this->createForm(CameraType::class, $camera);
        $formCamera->handleRequest($request);

        $formImage = $this->createForm(PhotoType::class, $imageCamera);
        $formImage->handleRequest($request);

        if ($formCamera->isSubmitted() && $formCamera->isValid()) {

            $camera = $formCamera->getData();

            $imageCamera->setCamera($camera);
            $entityManager->persist($imageCamera);

            $entityManager->persist($camera);
            $entityManager->flush();

            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        }

        return $this->render('admin/Cameras/addProduct.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView(),
        ]);
    }
}
