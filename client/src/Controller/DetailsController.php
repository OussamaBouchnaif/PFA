<?php

namespace App\Controller;

use App\Service\Api\CallApiCameraService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_details')]
    public function index(int $id,CallApiCameraService $callapi): Response
    {
        return $this->render('client/pages/product-details.html.twig', [
            'camera' => $callapi->getCameraById($id),
        ]);
    }
}
