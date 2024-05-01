<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Forms\AvisType;
use App\Entity\AvisCamera;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\AvisCameraRepository;
use App\Cart\Handler\CartStorageInterface;
use App\Service\Api\Cameras\AbstractCameraFetcher;
use App\Service\Api\Cameras\CameraFetcher;
use App\Service\Api\Cameras\CameraFetcherInterface;
use App\Service\Api\Cameras\getAllCameras;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsController extends AbstractController
{

    public function __construct(
        private CartStorageInterface $cartStorage,
        private CameraFetcherInterface $cameraFetcher,
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function index(Camera $camera, Request $request): Response
    {
        $avisCamera = new AvisCamera();
        $form = $this->createForm(AvisType::class,$avisCamera);
        $form->handleRequest($request);
        $comments = $camera->getAvisCameras();
        
        if ($form->isSubmitted() && $form->isValid()) {

            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {

                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                $avisCamera = $form->getData();
                $this->manager->getRepository(AvisCamera::class)->addAvisCamera($avisCamera,$camera, $this->getUser());

                return $this->render('client/pages/components/avis.stream.html.twig', [
                    'content' => $avisCamera->getCommentaire(),
                    'name' => $this->getUser()->getNom(),
                    'createdAt' => new \DateTimeImmutable(),
                    'start' => $avisCamera->getNote(),
                ]); // Pass just the content string
            }
        }
        return $this->render('client/pages/product-details.html.twig', [
            'camera' => $this->cameraFetcher->getCameraById($camera->getId()),
            'form' => $form->createView(),
            'comments' => $comments,
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
    }
}
