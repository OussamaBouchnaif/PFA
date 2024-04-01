<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Entity\Categorie;
use App\Entity\ImageCamera;
use App\Form\CameraType;
use App\Form\PhotoType;
use App\Repository\CategorieRepository;
use App\Repository\CameraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CameraController extends AbstractController
{


    #[Route('/cus', name: 'cus')]
    public function cus(): Response
    {
        return $this->render('admin/Cameras/customers.html.twig');
    }

    #[Route('/camera/details/{id}', name: 'camera_details')]
    public function cameraDetails(Camera $camera, CameraRepository $cameraRepository): Response
    {
        return $this->render('admin/Cameras/details.html.twig', [
            'camera' => $camera,

        ]);
    }
    #[Route('/camera', name: 'camera')]
    public function showCamera(Request $request, CameraRepository $cameraRepository, CategorieRepository $categorieRepository): Response
    {
        $cameras = $cameraRepository->findAll();
        $categories = $categorieRepository->findAll(); // Récupérer toutes les catégories depuis le repository

        return $this->render('admin/Cameras/ShowProduct.html.twig', [
            'cameras' => $cameras,
            'categories' => $categories, // Passer les catégories à la vue Twig
        ]);
    }

    #[Route('/camera/Add_camera', name: 'Add_camera')]
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
   
#[Route('/camera/Edit_camera/{id}', name: 'Edit_camera')]
public function editCamera(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    // Fetch the camera entity to edit
    $camera = $entityManager->getRepository(Camera::class)->find($id);
    
    if (!$camera) {
        throw $this->createNotFoundException('Camera not found');
    }

    // Create form for camera details
    $formCamera = $this->createForm(CameraType::class, $camera);
    $formCamera->handleRequest($request);

    // Create form for photo
    $imageCamera = new ImageCamera();
    $formImage = $this->createForm(PhotoType::class, $imageCamera);
    $formImage->handleRequest($request);

    if ($formCamera->isSubmitted() && $formCamera->isValid()) {
        // Handle camera form submission
        $entityManager->flush();

        $this->addFlash('success', 'Camera details updated successfully!');
        return $this->redirectToRoute('camera');
    }

    if ($formCamera->isSubmitted() && $formCamera->isValid()) {

        $camera = $formCamera->getData();

        $imageCamera->setCamera($camera);
        $entityManager->persist($imageCamera);

        $entityManager->persist($camera);
        $entityManager->flush();

        $this->addFlash('success', 'Camera added successfully!');
        return $this->redirectToRoute('camera');
    }

    return $this->render('admin/Cameras/editProduct.html.twig', [
        'form' => $formCamera->createView(),
        'camera' => $camera,
        'formI' => $formImage->createView(),
    ]);
}


    #[Route('/camera/Delete_camera/{id}', name: 'Delete_camera')]
    public function deleteCamera(EntityManagerInterface $entityManager, CameraRepository $cameraRepository, $id): Response
    {
        $camera = $cameraRepository->find($id);

        if (!$camera) {
            throw $this->createNotFoundException('Camera not found');
        }

        // Supprimer toutes les images associées à cette caméra
        foreach ($camera->getImageCameras() as $imageCamera) {
            $entityManager->remove($imageCamera);
        }

        // Supprimer la caméra
        $entityManager->remove($camera);
        $entityManager->flush();
        $this->addFlash('success', 'Camera deleted successfully!');

        return $this->redirectToRoute('camera');
    }
}
