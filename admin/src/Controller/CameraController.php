<?php

namespace App\Controller;

use App\Form\CameraType;
use App\Entity\Camera;
use App\Entity\ImageCamera;
use App\Form\PhotoType;
use App\Entity\Client;
use App\Entity\CodePromo;
use App\Entity\Commande;
use App\Repository\CameraRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Knp\Component\Pager\PaginatorOptions;
use Knp\Component\Pager\Pagination\PaginationInterface;
class CameraController extends AbstractController
{
    #[Route('/', name: 'ds')]
    public function dash(): Response
    {
        return $this->render('dashboard/admin/test.html.twig');
    }
      //detail 
    
      #[Route('/camera/details/{id}', name: 'camera_details')]
      public function cameraDetails(Camera $camera, CameraRepository $cameraRepository): Response
      {
                     return $this->render('dashboard/camera/camera-details.html.twig', ['camera' => $camera]);
      }
     
      
            #[Route('/camera', name: 'camera')]
        public function showCamera(CameraRepository $cameraRepository, Request $request, PaginatorInterface $paginator): Response
        {
            $page = $request->query->getInt('page', 1);
            $limit = 10;

            $paginatedCameras = $paginator->paginate(
                $cameraRepository->findAll(), 
                $page,
                $limit 
            );

            // Passez la pagination au template
            return $this->render('dashboard/camera/camera_list.html.twig', [
                'pagination' => $paginatedCameras
            ]);
        }
    #[Route('/Add_camera', name: 'Add_camera')]
    public function addCamera(Request $request, EntityManagerInterface $entityManager): Response
    {
        $camera = new Camera();
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function EditCamera(Camera $camera, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        return $this->redirectToRoute('camera');
    }

  
#[Route('/upload_photo/{id}', name: 'upload_photo')]
public function uploadPhoto(Camera $camera, Request $request, EntityManagerInterface $entityManager): Response
{
    $imageCamera = new ImageCamera();
    $form = $this->createForm(PhotoType::class, $imageCamera);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $uploadedFile = $form->get('photo')->getData();

        $newFilename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->getParameter('kernel.project_dir') . '/public/uploads', $newFilename);

        $imageCamera->setImage($newFilename);
        $imageCamera->setCamera($camera);

        $entityManager->persist($imageCamera);
        $entityManager->flush();

        $this->addFlash('success', 'Photo ajoutée avec succès!');

        return $this->redirectToRoute('camera');
    }

    return $this->render('dashboard/camera/upload_photo.html.twig', [
        'form' => $form->createView(),
        'camera' => $camera,
    ]);
}
    #[Route('/download_photo/{id}', name: 'download_photo')]
    public function downloadPhoto(ImageCamera $imageCamera): BinaryFileResponse
    {
        $photoPath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $imageCamera->getImage();

        return $this->file($photoPath, null, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    // #[Route('/command', name: 'user')]
    // public function command(EntityManagerInterface $manager, CommandeRepository $repo): Response
    // {
    //     // ... (your existing code) ...
    // }

    // #[Route('/pub', name: 'appt')]
    // public function publish(HubInterface $hub): Response
    // {
    //     // ... (your existing code) ...
    // }
}
