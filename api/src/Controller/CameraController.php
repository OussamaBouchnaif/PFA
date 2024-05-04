<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Entity\CartItem;
use App\Entity\Categorie;
use App\Repository\CameraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CameraController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager,
    private SerializerInterface $serializer)
    {
    }

    #[Route("/api/welcome", name: "test", methods: ['GET'])]
    public function test(): JsonResponse
    {
        $cameras = $this->manager->getRepository(Camera::class)->findAll(); 
        if(null === $cameras)
        {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($cameras, 'json', ['groups' => 'camera:read']);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
      
    }

    #[Route("/api/cameras/latest", name: "latest", methods: ['GET'], priority: 2)]
    public function lastTen(): JsonResponse
    {
        $cameras = $this->manager->getRepository(Camera::class)->findLastCameras();
        if(null === $cameras)
        {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($cameras, 'json', ['groups' => 'camera:read']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
      
    }

    #[Route('/api/cameras/mostOrders' ,name:"mostOrders" , methods:['GET'] , priority: 3)]
    public function cameraWithMostOrders()
    {
        $cameras = $this->manager->getRepository(CartItem::class)->theMostOrder();
        if(null === $cameras)
        {
            return new JsonResponse(null,Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($cameras, 'json', ['groups' => 'camera:read']);
        return new JsonResponse($data, Response::HTTP_OK, [], true);

    }

   /*  #[Route('/api/cameras/related' ,name:"mostOrders" , methods:['GET'] , priority: 3)]
    public function related()
    {
        $cameras = $this->manager->getRepository(Categorie::class)->related();
        if(null === $cameras)
        {
            return new JsonResponse(null,Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($cameras, 'json', ['groups' => 'camera:read']);
        return new JsonResponse($data, Response::HTTP_OK, [], true);

    } */
    
    
}
