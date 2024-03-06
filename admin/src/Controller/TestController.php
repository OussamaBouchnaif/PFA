<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Form\CameraType;
use App\Entity\ImageCamera;
use App\Form\PhotoType;
use App\Repository\CameraRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ImageCameraRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $formCamera = $this->createForm(CameraType::class, $camera);
        $formImage = $this->createForm(PhotoType::class, $imageCamera);
        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);
        // dd($formCamera->getData());
        if ($formCamera->isSubmitted() ) {
            $camera = $formCamera->getData();

            $image = $formImage->getData();

            
            $image->setCamera($camera);
            $entityManager->persist($image);
            $entityManager->persist($camera);
            $entityManager->flush();
            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        } 
        return $this->render('admin/Cameras/addProduct.html.twig', [
     
            'form' => $formCamera->createView(),'formI' => $formImage->createView(),
        ]);
    }
}

