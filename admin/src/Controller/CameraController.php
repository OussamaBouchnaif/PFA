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
        return $this->render('dashboard/admin/test.html.twig');
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
        $imageCamera = new ImageCamera();
        $formCamera = $this->createForm(CameraType::class, $camera);
        $formImage = $this->createForm(PhotoType::class, $imageCamera);
        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);
    
        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
            $camera = $formCamera->getData();
            $image = $formImage->getData()->getimageFile();
            
            $imageCamera->setImage($image); 
            $camera->addImageCamera($imageCamera);
            $entityManager->persist($imageCamera);
            $entityManager->persist($camera);
            $entityManager->flush();
            $this->addFlash('success', 'Camera added successfully!');
            return $this->redirectToRoute('camera');
        } 
        return $this->render('dashboard/camera/camera_form.html.twig', [
            'form' => $formCamera->createView(),'formI' => $formImage->createView(),
        ]);
    }

    
    #[Route('/Edit_camera/{id}', name: 'Edit_camera')]
    public function editCamera(Request $request, EntityManagerInterface $entityManager, Camera $camera): Response
    {
        // Créer le formulaire de modification de la caméra avec les données de la caméra existante
        $formCamera = $this->createForm(CameraType::class, $camera, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);
        
        // Créer le formulaire de modification de l'image de la caméra
        $formImage = $this->createForm(PhotoType::class, null, [
            'attr' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
        ]);
    
        $formCamera->handleRequest($request);
        $formImage->handleRequest($request);
    
        // Vérifier si le formulaire de modification de la caméra est soumis et valide
        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
            // Si le formulaire est soumis et valide, enregistrer les modifications dans la base de données
            $entityManager->flush();
    
            // Ajouter un message flash pour confirmer la modification
            $this->addFlash('success', 'Camera updated successfully!');
    
            // Rediriger vers la liste des caméras ou une autre page appropriée
            return $this->redirectToRoute('camera');
        }
    
        // Afficher le formulaire de modification de la caméra
        return $this->render('dashboard/camera/edit_camera.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView(),
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
