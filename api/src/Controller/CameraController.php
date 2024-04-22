<?php

namespace App\Controller;

use App\Repository\CameraRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CameraController extends AbstractController
{
    #[Route("/api/welcome", name: "test", methods: ['GET'])]
    public function test(CameraRepository $cameraRepository, SerializerInterface $serializer): JsonResponse
    {
        $cameras = $cameraRepository->findAll();
        $data = $serializer->serialize($cameras, 'json', ['groups' => 'camera:read']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
      
    }
    #[Route("/api/cameras/latest", name: "latest", methods: ['GET'], priority: 2)]
    public function lastTen(CameraRepository $cameraRepository, SerializerInterface $serializer,Request $request): JsonResponse
    {
        $cameras = $cameraRepository->findLastCameras();
        $data = $serializer->serialize($cameras, 'json', ['groups' => 'camera:read']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
      
    }
    
}
