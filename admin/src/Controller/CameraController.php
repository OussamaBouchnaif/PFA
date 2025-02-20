<?php

namespace App\Controller;

use App\Entity\AvisCamera;
use App\Entity\Camera;
use App\Entity\Commande;
use App\Entity\ImageCamera;
use App\Entity\LigneReduction;
use App\Form\CameraType;
use App\Form\PhotoType;
use App\Repository\CameraRepository;
use App\Repository\CategorieRepository;
use App\Services\CameraModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CameraController extends AbstractController
{
    public function __construct(
        private CameraModel $cameraModel,
        private EntityManagerInterface $manager,
    ) {
    }


    #[Route('/camera/details/{id}', name: 'camera_details')]
    public function cameraDetails(Camera $camera, CameraRepository $cameraRepository): Response
    {
        return $this->render('admin/Cameras/details.html.twig', [
            'camera' => $camera,
        ]);
    }
    #[Route('/', name: 'home')]
    public function home(Request $request, CameraRepository $cameraRepository, CategorieRepository $categorieRepository): Response
    {
        $cameras = $cameraRepository->findAll();
        $categories = $categorieRepository->findAll(); // Récupérer toutes les catégories depuis le repository

        return $this->render('admin/Cameras/ShowProduct.html.twig', [
            'cameras' => $cameras,
            'categories' => $categories, // Passer les catégories à la vue Twig
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
    public function addCamera(Request $request, EntityManagerInterface $entityManager, CameraModel $cameraModel): Response
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

            return $cameraModel->addCamera($camera, $imageCamera);
        }

        return $this->render('admin/Cameras/addProduct.html.twig', [
            'form' => $formCamera->createView(),
            'formI' => $formImage->createView(),
        ]);
    }

    #[Route('/camera/Edit_camera/{id}', name: 'Edit_camera')]
    public function editCamera(Request $request, EntityManagerInterface $entityManager, Camera $camera, CameraModel $cameraModel): Response
    {
        $imageCamera = new ImageCamera();

        $formCamera = $this->createForm(CameraType::class, $camera);
        $formCamera->handleRequest($request);

        $formImage = $this->createForm(PhotoType::class, $imageCamera);
        $formImage->handleRequest($request);

        if ($formCamera->isSubmitted() && $formCamera->isValid()) {
            // Handle camera form submission
            $cameraModel->editCamera($camera, $imageCamera, $request);

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

        foreach ($camera->getImageCameras() as $imageCamera) {
            $entityManager->remove($imageCamera);
        }

        $reductions = $entityManager->getRepository(LigneReduction::class)->findBy(['camera' => $camera]);
        foreach ($reductions as $reduction) {
            $entityManager->remove($reduction);
        }
        $avis = $entityManager->getRepository(AvisCamera::class)->findBy(['camera' => $camera]);
        foreach ($avis as $avi) {
            $entityManager->remove($avi);
        }

        $entityManager->remove($camera);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'Camera deleted successfully']);
    }
    #[Route('/camera/chart', name: 'camera_chart')]
    public function chart(): Response
    {
        $currentYear = date('Y');
        $countCommandes = $this->manager->getRepository(Commande::class)->countCommandesByStatus();
        $commandesParJour = $this->manager->getRepository(Commande::class)->getCommandesParJour();
        $revenuMensuel = $this->manager->getRepository(Commande::class)->getRevenuMensuel();
        $produitsLesPlusVendus = $this->manager->getRepository(Commande::class)->getProduitsLesPlusVendus();
        $totalCommandes = $this->manager->getRepository(Commande::class)->getTotalCommandes();
        $totalRevenueYear = $this->manager->getRepository(Commande::class)->getTotalRevenueByYear((int)$currentYear);
        $commandesParAn = $this->manager->getRepository(Commande::class)->getCommandesParAn(); 
        $commandesAnnulees = $this->manager->getRepository(Commande::class)->countCommandeAnulees();
        return $this->render('admin/Cameras/chart.html.twig', [
            'countCommandes' => $countCommandes,
            'commandesAnnulees' => $commandesAnnulees,
            'commandesParJour' => $commandesParJour,
            'revenuMensuel' => $revenuMensuel,
            'produitsLesPlusVendus' => $produitsLesPlusVendus,
            'totalCommandes' => $totalCommandes,
            'totalRevenueYear' => $totalRevenueYear,
            'commandesParAn' => $commandesParAn,
            'displayCharts' => true,
        ]);
    }



}
