<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Repository\CameraRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    
    private $client;
    private $serializer;
    public function __construct(HttpClientInterface $client,SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

   
    #[Route("/camera",name:"app_camera")]
    public function fetchMessage(): Response
    {
        $response = $this->client->request('GET', 'http://api/api/welcome');
        $content = $response->getContent();
        
        // Désérialiser JSON en tableau PHP
        $data = $this->serializer->deserialize($content, 'App\Entity\Camera[]', 'json');

         return $this->render('client/pages/shop.html.twig', [
            'cameras'=> $data,
        ]);
    }
}
