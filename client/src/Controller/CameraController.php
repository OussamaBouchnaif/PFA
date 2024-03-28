<?php

namespace App\Controller;

use App\Cart\Handler\CartStorageInterface;
use App\Entity\CartItem;
use App\Forms\CartItemType;
use App\Repository\CameraRepository;
use App\Repository\CartItemRepository;
use App\Repository\CategorieRepository;
use App\Service\Api\CallApiCameraService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    private CategorieRepository $categorie;
    private CallApiCameraService $callCamera;
    private CameraRepository $cameraRepo;
    private CartStorageInterface $cartStorage;
    public function __construct(CategorieRepository $categorie,
    CallApiCameraService $callCamera,CameraRepository $cameraRepo,
    CartStorageInterface $cartStorage
    )
    {
        $this->categorie = $categorie;
        $this->callCamera = $callCamera;
        $this->cameraRepo = $cameraRepo;
        $this->cartStorage = $cartStorage;
    }


    #[Route('/camera/search', name: 'camera_search')]
    public function search(Request $request,PaginatorInterface $paginator, SessionInterface $session): Response
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
        $cameras = $this->callCamera->SearchBy($searchCriteria);
        $data = $this->cameraRepo->pagination($cameras,$page,$paginator);
        return $this->render('client/pages/shop.html.twig', [
            'cameras' => $data,
            'categories'=> $this->categorie->findAll(),
            'items'=>$this->callCamera->getItems(),
            'pagination'=>$this->cameraRepo->extractPaginationInfo(ceil($data->getTotalItemCount() / 9),$page),
            'route' => 'camera_search',
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
      
       
    }

    #[Route('/fetchCamera',name:'fetch')]
    public function fetch(Request $request,SessionInterface $session):Response
    {
        
        $session->remove('searchCriteria');
        $page = $request->query->getInt('page',1);   

        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $this->callCamera->getAllCamera($page),
            'categories'=> $this->categorie->findAll(),
            'items'=>$this->callCamera->getItems(),
            'pagination' => $this->cameraRepo->extractPaginationInfo(ceil($this->callCamera->getItems()/9),$page),
            'route' => 'fetch',
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),

        ]);
       
    }
   
  

}
