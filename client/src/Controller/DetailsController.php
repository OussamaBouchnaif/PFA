<?php

namespace App\Controller;

use App\Entity\AvisCamera;
use App\Entity\Camera;
use App\Forms\AvisType;
use App\Service\Api\Cameras\CameraFetcherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Turbo\TurboBundle;

class DetailsController extends AbstractController
{
    public function __construct(
        private CameraFetcherInterface $cameraFetcher,
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function index(Camera $camera, Request $request): Response
    {
        $avisCamera = new AvisCamera();
        $form = $this->createForm(AvisType::class, $avisCamera);
        $form->handleRequest($request);
        $comments = $camera->getAvisCameras();

        if ($form->isSubmitted() && $form->isValid()) {
            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                $avisCamera = $form->getData();
                $this->manager->getRepository(AvisCamera::class)->addAvisCamera($avisCamera, $camera, $this->getUser());

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
        ]);
    }
}
