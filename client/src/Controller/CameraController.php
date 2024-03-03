<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Repository\CameraRepository;
use App\Repository\CategorieRepository;
use App\Service\Api\CallApiCameraService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    #[Route('/camera',name:'app_camera')]
    public function delete(SessionInterface $session):Response
    {
        $session->remove('searchCriteria');
        return $this->redirectToRoute('camera_search');
    }

    #[Route('/camera/search', name: 'camera_search')]
    public function search(Request $request, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session,PaginatorInterface $paginatorInterface): Response
    {
        
        $searchCriteria = $session->get('searchCriteria', array());

        $newCriteria = [
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle'),
            'prix' => $request->query->get('price_range') ? implode('..', array_map(function($price) { return floatval(str_replace('$', '', $price)); }, explode(' - ', $request->query->get('price_range')))) : null,
        ];
    
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
    
        $session->set('searchCriteria', $searchCriteria);
        $cameras = $callApiCameraService->searchCameras($searchCriteria);
        $data = $paginatorInterface->paginate(
            $cameras,
            $request->query->getInt('page',1),
            9
        );
        $categorie = $catrepo->findAll();
    
        return $this->render('client/pages/shop.html.twig', [
            'cameras' => $data,
            'categories'=> $categorie,
        ]);
    }
    
    #[Route('/cat',name:'categorie')]
    public function dd(Request $request):Response
    {
        dd($request->query->get('categorie'));
    }

   

/*    #[Route('/filter_cat/{id}',name:'filter_cat')]
    public function filterByCategorie(int $id,CategorieRepository $catrepo,CallApiCameraService $callapi,PaginatorInterface $paginatorInterface , Request $request):Response
    {
        $categorie = $catrepo->findOneBy(['id'=>$id]);
        $camerasByCategorie = $callapi->getCameraByCategorie($categorie->getNom());
        $data = $paginatorInterface->paginate(
            $camerasByCategorie,
            $request->query->getInt('page',1),
            9
        );
      
        return $this->render('client/pages/cameras.html.twig',[
            'cameras' =>$data ,
            'categories' => $catrepo->findAll(),
        ]);
    }

    #[Route('/filter_price' ,name:'filter_price')]
    public function filterByPrice(Request $request,CallApiCameraService $callapi,CategorieRepository $catrepo,PaginatorInterface $paginatorInterface):Response
    {
        
        $priceRange = $request->query->get('price_range'); // '144 - 271'
        [$minPrice, $maxPrice] = explode(' - ', str_replace('$', '', $priceRange));
        $minPrice = floatval($minPrice);
        $maxPrice = floatval($maxPrice);
        $camerasByPrice = $callapi->getCameraByPrix($minPrice,$maxPrice);
        $data = $paginatorInterface->paginate(
            $camerasByPrice,
            $request->query->getInt('page',1),
            9
        );
      
       
        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $data,
            'categories' => $catrepo->findAll(),
        ]);
    }

    #[Route('/filter_angle/{angle}',name:'filterAngle')]
    public function filterByAngle(string $angle,CallApiCameraService $callapi):Response
    {
        dd($callapi->getCameraByAngle($angle));
        return $this->render('client/pages/shop.hmtl.twig',[
            'angels' => $callapi->getCameraByAngle($angle),
        ]);
    }*/
}
