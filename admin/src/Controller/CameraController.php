<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Entity\ImageCamera;
use App\Form\CameraType;
use App\Form\PhotoType;
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
    #[Route('/', name: 'ds')]
    public function dash(): Response
    {
        return $this->render('admin/addProduct.html.twig');
    }

    #[Route('/camera/details/{id}', name: 'camera_details')]
    public function cameraDetails(Camera $camera, CameraRepository $cameraRepository): Response
    {
        return $this->render('dashboard/camera/camera-details.html.twig', ['camera' => $camera]);
    }

    #[Route('/camera', name: 'camera')]
    public function showCamera(Request $request, CameraRepository $cameraRepository): Response
    {
         $cameras = $cameraRepository->findAll();

         return $this->render('dashboard/camera/camera_list.html.twig', [
            'cameras' => $cameras,
        ]);
        
    }

    #[Route('/Add_camera', name: 'Add_camera')]
    public function addCamera(Request $request, EntityManagerInterface $entityManager): Response
    {
        $camera = new Camera();
        $form = $this->createForm(CameraType::class, $camera, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $request->files->get('camera')['imageFile'];
    
            foreach ($uploadedFiles as $uploadedFile) {
                $imageCamera = new ImageCamera();
                $imageCamera->setImage($uploadedFile); // Assuming setImage method handles file uploading
                $camera->addImageCamera($imageCamera);
            }
            $entityManager->persist($camera);
            $entityManager->flush();
            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        } 
        return $this->render('dashboard/camera/camera_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    
    #[Route('/Edit_camera/{id}', name: 'Edit_camera')]
    public function editCamera(Camera $camera, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des photos
            $uploadedFiles = $form->get('imageFile')->getData();
    
            foreach ($uploadedFiles as $uploadedFile) {
                $newFilename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($this->getParameter('kernel.project_dir') . '/public/uploads', $newFilename);
    
                $imageCamera = new ImageCamera();
                $imageCamera->setImage($newFilename);
                $imageCamera->setCamera($camera);
                $entityManager->persist($imageCamera);
            }
    
            // Flush seulement après la gestion des photos
            $entityManager->flush();
    
            $this->addFlash('success', 'Camera updated successfully!');
    
            return $this->redirectToRoute('camera');
        }
    
        return $this->render('dashboard/camera/edit_camera.html.twig', [
            'form' => $form->createView(),
            'camera' => $camera,
        ]);
    }
    

    #[Route('/Delete_camera/{id}', name: 'Delete_camera')]
    public function deleteCamera(EntityManagerInterface $entityManager, CameraRepository $cameraRepository, $id): Response
    {
        $camera = $cameraRepository->find($id);

        if (!$camera) {
            throw $this->createNotFoundException('Camera not found');
        }

        $entityManager->remove($camera);
        $entityManager->flush();
        $this->addFlash('success', 'Camera deleted successfully!');

        return $this->redirectToRoute('camera');
    }

    // #[Route('/upload_photo/{id}', name: 'upload_photo')]
    // public function uploadPhoto(Camera $camera, Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $imageCamera = new ImageCamera();
    //     $form = $this->createForm(PhotoType::class, $imageCamera);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $uploadedFile = $form->get('photo')->getData();

    //         $newFilename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
    //         $uploadedFile->move($this->getParameter('kernel.project_dir') . '/public/uploads', $newFilename);

    //         $imageCamera->setImage($newFilename);
    //         $imageCamera->setCamera($camera);

    //         $entityManager->persist($imageCamera);
    //         $entityManager->flush();

    //         $this->addFlash('success', 'Photo ajoutée avec succès!');

    //         return $this->redirectToRoute('camera');
    //     }

    //     return $this->render('dashboard/camera/upload_photo.html.twig', [
    //         'form' => $form->createView(),
    //         'camera' => $camera,
    //     ]);
    // }

    #[Route('/download_photo/{id}', name: 'download_photo')]
    public function downloadPhoto(ImageCamera $imageCamera): BinaryFileResponse
    {
        $photoPath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $imageCamera->getImage();

        return $this->file($photoPath, null, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
