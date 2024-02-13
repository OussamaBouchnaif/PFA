<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Repository\CameraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CameraController extends AbstractController
{
    #[Route('/camera', name: 'app_camera')]
    public function index(CameraRepository $camRepo): Response
    {

        $cameras = $camRepo->findAll();
        return $this->render('client/pages/shop.html.twig', [
            'cameras'=> $cameras,
        ]);
    }
}
