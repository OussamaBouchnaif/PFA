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
use Doctrine\ORM\ORMException;

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

            // Retourner une réponse JSON avec un message de succès
            return new JsonResponse([
                'message' => 'Camera added successfully!',
            ]);
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
    public function deleteCamera(EntityManagerInterface $entityManager, CameraRepository $cameraRepository, $id): JsonResponse
    {
        $camera = $cameraRepository->find($id);

        if (!$camera) {
            return new JsonResponse(['success' => false, 'message' => 'Camera not found'], 404);
        }

        // Supprimer toutes les images associées à cette caméra
        foreach ($camera->getImageCameras() as $imageCamera) {
            $entityManager->remove($imageCamera);
        }

        // Supprimer la caméra
        $entityManager->remove($camera);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'Camera deleted successfully']);
    }

    #[Route('/add_photo', name: 'add_photo', methods: ['POST'])]
    public function addPhoto(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $imageCamera = new ImageCamera();

            $formImage = $this->createForm(PhotoType::class, $imageCamera);
            $formImage->handleRequest($request);

            if ($formImage->isSubmitted() && $formImage->isValid()) {
                $imageCamera = $formImage->getData();
                $entityManager->persist($imageCamera);
                $entityManager->flush();

                // Redirigez vers une autre page ou retournez une réponse si nécessaire
                return $this->redirectToRoute('camera');
            } else {
                return $this->render('error_page.html.twig', [
                    'form' => $formImage->createView(),
                ]);
            }
        } catch (\Exception $e) {
            // Gérer l'erreur
            $this->addFlash('error', 'An error occurred while adding the photo.');

            // Redirigez ou retournez une réponse avec des erreurs
            return $this->redirectToRoute('camera');
        }
    }
    #[Route('/camera/chart', name: 'camera_chart')]
    public function chart(EntityManagerInterface $entityManager): Response
    {
        // Récupérer le repository de l'entité Categorie
        $categorieRepository = $entityManager->getRepository(Categorie::class);
        
        // Récupérer toutes les catégories avec le nombre de caméras associées
        $categoriesWithCameraCount = $categorieRepository->createQueryBuilder('c')
            ->select('c.nom as category_name', 'COUNT(ca.id) as camera_count')
            ->leftJoin('c.cameras', 'ca')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    
        // Convertir le résultat en un tableau associatif
        $categoriesData = [];
        foreach ($categoriesWithCameraCount as $data) {
            $categoriesData[$data['category_name']] = $data['camera_count'];
        }
    
        return $this->render('admin/Cameras/chart.html.twig', [
            'camerasByCategory' => $categoriesData,
        ]);
    }
    
}
