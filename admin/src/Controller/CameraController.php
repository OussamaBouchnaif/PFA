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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
    public function addCamera(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $camera = new Camera();
        $imageCamera = new ImageCamera();
        $formCamera = $this->createForm(CameraType::class, $camera);
        $formImage = $this->createForm(PhotoType::class, $imageCamera);
        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);
    
        if ($formCamera->isSubmitted() && $formCamera->isValid() && $formImage->isValid()) {
            $camera = $formCamera->getData();
<<<<<<< HEAD
            $image = $formImage->getData();
            
            $image->setCamera($camera);
            $entityManager->persist($image);
=======
            $imageCamera = $formImage->getData();
    
            // Set the camera for the image
            $imageCamera->setCamera($camera);
    
            // Persist the camera entity first
>>>>>>> b926118 (data)
            $entityManager->persist($camera);
            $entityManager->flush();
    
            // Handle file upload for imageCamera using VichUploaderBundle
            $imageFile = $imageCamera->getImageFile();
            if ($imageFile) {
                $imageName = $uploaderHelper->asset($imageCamera, 'imageFile');
                $imageCamera->setImage($imageName);
            }
    
            // Persist the imageCamera entity
            $entityManager->persist($imageCamera);
            $entityManager->flush();
    
            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        }
    
        return $this->render('admin/Cameras/addProduct.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView()
        ]);
    }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD

    #[Route('/camera/Edit_camera/{id}', name: 'Edit_camera')]
    public function editCamera(Request $request, EntityManagerInterface $entityManager, Camera $camera): Response
    {
        $formCamera = $this->createForm(CameraType::class, $camera, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);

        $formImage = $this->createForm(PhotoType::class, null, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);
=======
    
      #[Route('/camera/Edit_camera/{id}', name: 'Edit_camera')]
        public function editCamera(Request $request, EntityManagerInterface $entityManager, Camera $camera): Response
        {
            $formCamera = $this->createForm(CameraType::class, $camera, [
                'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
            ]);
>>>>>>> 870065d (Add User whith photo and Security)

        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);

        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Camera updated successfully!');
            return $this->redirectToRoute('camera');
        }

<<<<<<< HEAD
        return $this->render('admin/Cameras/editProduct.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView(),
        ]);
    }

    

        #[Route('/Delete_camera/{id}', name: 'Delete_camera')]
=======
        #[Route('/camera/Delete_camera/{id}', name: 'Delete_camera')]
>>>>>>> 870065d (Add User whith photo and Security)
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
=======

=======
>>>>>>> b926118 (data)
    #[Route('/camera/Edit_camera/{id}', name: 'Edit_camera')]
    public function editCamera(Request $request, EntityManagerInterface $entityManager, Camera $camera): Response
    {
        $formCamera = $this->createForm(CameraType::class, $camera, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);

        $formImage = $this->createForm(PhotoType::class, null, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);

        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);

        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
>>>>>>> b42b885 (fixer image user)
            $entityManager->flush();
            $this->addFlash('success', 'Camera updated successfully!');
            return $this->redirectToRoute('camera');
        }

        return $this->render('admin/Cameras/editProduct.html.twig', [
            'form' => $formCamera->createView(),
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
