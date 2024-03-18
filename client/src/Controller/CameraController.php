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


    #[Route('/camera',name:'app_camera')]
    public function delete(SessionInterface $session):Response
    {
        $session->remove('searchCriteria');
        return $this->redirectToRoute('fetch');
    }

    #[Route('/camera/search', name: 'camera_search')]
    public function search(Request $request,SessionInterface $session): Response
    {     
        $page = $request->query->getInt('page',1);        
        $newCriteria = [
            'order' => $request->query->get('orderby'),
            'resolution' => $request->query->get('res'),
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle'),
            'prix' => $request->query->get('price_range') ? implode('..', array_map(function($price) { return floatval(str_replace('$', '', $price)); }, explode(' - ', $request->query->get('price_range')))) : null,
            
        ];
        $searchCriteria = $this->cameraRepo->fillInTheSession($newCriteria,$session);
        $session->set('searchCriteria', $searchCriteria);
        
        return $this->render('client/pages/components/cameras.html.twig', [
            'cameras' => $this->callCamera->SearchBy($searchCriteria,$page,9),
            'categories'=> $this->categorie->findAll(),
            'pagination' => $this->cameraRepo->extractPaginationInfo($page),
            'items'=>$this->callCamera->getItems(),
            'currentRoute' => 'camera_search',
            
        ]);
      
       
    }

    #[Route('/fetchCamera',name:'fetch')]
    public function fetch(CallApiCameraService $callCamera,Request $request):Response
    {
        $page = $request->query->getInt('page',1);   

        return $this->render('client/pages/shop.html.twig',[
            'cameras' =>$callCamera->getAllCamera($page),
            'categories'=> $this->categorie->findAll(),
            'pagination' => $this->cameraRepo->extractPaginationInfo($page),
            'items'=>$this->callCamera->getItems(),
            'currentRoute' => 'fetch',
        ]);
    }

  
    
    
 
   

}
