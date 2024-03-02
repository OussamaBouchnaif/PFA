<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Repository\CameraRepository;
use App\Repository\CategorieRepository;
use App\Service\Api\CallApiCameraService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{

   
    #[Route("/camera", name: "app_camera")]
    public function fetchCameras(CallApiCameraService $callapi,CategorieRepository $catrepo): Response
    {
        
        return $this->render('client/pages/shop.html.twig', [
            'cameras'=> $callapi->getAllCamera(),
            'categories' => $catrepo->findAll(),
        ]);
    }

    #[Route('/filter_cat/{id}',name:'filter_cat')]
    public function filterByCategorie(int $id,CategorieRepository $catrepo,CallApiCameraService $callapi):Response
    {
        $categorie = $catrepo->findOneBy(['id'=>$id]);
        
        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $callapi->getCameraByCategorie($categorie->getNom()),
            'categories' => $catrepo->findAll(),
        ]);
    }

    #[Route('/filter_price' ,name:'filter_price')]
    public function filterByPrice(Request $request,CallApiCameraService $callapi,CategorieRepository $catrepo):Response
    {
        
        $priceRange = $request->query->get('price_range'); // '144 - 271'
        [$minPrice, $maxPrice] = explode(' - ', str_replace('$', '', $priceRange));

        // Convertir en numérique si nécessaire
        $minPrice = floatval($minPrice);
        $maxPrice = floatval($maxPrice);
       
        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $callapi->getCameraByPrix($minPrice,$maxPrice),
            'categories' => $catrepo->findAll(),
        ]);


    }
}
