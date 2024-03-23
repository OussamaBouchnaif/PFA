<?php

namespace App\Controller;

use App\Entity\Camera;
use Symfony\UX\Turbo\TurboBundle;
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
    private CategorieRepository $categorie;
    private CallApiCameraService $callCamera;
    private CameraRepository $cameraRepo;

    public function __construct(CategorieRepository $categorie,CallApiCameraService $callCamera,CameraRepository $cameraRepo)
    {
        $this->categorie = $categorie;
        $this->callCamera = $callCamera;
        $this->cameraRepo = $cameraRepo;
    }



<<<<<<< HEAD
    #[Route('/camera/search', name: 'camera_search')]
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function search(Request $request,CameraRepository $cameraRepository, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session): Response
    {     
        $page = $request->query->getInt('page',1);        
        $categorie = $catrepo->findAll();
        $newCriteria = [
            'order' => $request->query->get('orderby'),
>>>>>>> fa04ec1 (maintain search code)
            'resolution' => $request->query->get('res'),
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle'),
            'prix' => $request->query->get('price_range') ? implode('..', array_map(function($price) { return floatval(str_replace('$', '', $price)); }, explode(' - ', $request->query->get('price_range')))) : null,
            
        ];

        $searchCriteria = $cameraRepository->fillInTheSession($newCriteria,$session);
        $session->set('searchCriteria', $searchCriteria);
        
<<<<<<< HEAD
        $cameras = $callApiCameraService->SearchBy($searchCriteria,$page,9);
        $pagination = $cameraRepository->extractPaginationInfo($page);
        if ($request->isXmlHttpRequest()) {
           
            return $this->render('client/pages/components/cameras.html.twig', [
                'cameras' => $cameras,
                'categories'=> $categorie,
                'pagination' => $pagination,
                'items'=>$callApiCameraService->getItems(),
            ]);
        }
        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $cameras,
=======
    
=======
>>>>>>> 44d6728 (adapt api's pagination)
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
        
=======

        $searchCriteria = $cameraRepository->fillInTheSession($newCriteria,$session);
>>>>>>> fa04ec1 (maintain search code)
        $session->set('searchCriteria', $searchCriteria);
=======
>>>>>>> ca2bd99 (add sort by price and date)
        $cameras = $callApiCameraService->SearchBy($searchCriteria,$page,9);
        $pagination = $cameraRepository->extractPaginationInfo($page);
        if ($request->isXmlHttpRequest()) {
           
            return $this->render('client/pages/components/cameras.html.twig', [
                'cameras' => $cameras,
                'categories'=> $categorie,
                'pagination' => $pagination,
                'items'=>$callApiCameraService->getItems(),
            ]);
        }
        return $this->render('client/pages/shop.html.twig',[
<<<<<<< HEAD
            'cameras' => $data,
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
            'categories'=> $categorie,
            'pagination' => $pagination,
            'items'=>$callApiCameraService->getItems(),
        ]);
    }

  
    
    
 
   

}
