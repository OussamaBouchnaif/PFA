<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Repository\CameraRepository;
use App\Service\Api\CallApiCameraService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{

   
    #[Route("/camera", name: "app_camera")]
    public function fetchCameras(CallApiCameraService $callapi): Response
    {
        
        return $this->render('client/pages/shop.html.twig', [
            'cameras'=> $callapi->getCameraData(),
        ]);
    }
}
