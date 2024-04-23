<?php

namespace App\Controller;


use App\Formatter\PriceFormatter;

use App\Repository\CameraRepository;
use App\Repository\CategorieRepository;
use App\Cart\Handler\CartStorageInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Api\Cameras\CameraFetcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    public function __construct(
        private CategorieRepository $categorie,
        private CameraFetcherInterface $callCamera,
        private CameraRepository $cameraRepo,
        private CartStorageInterface $cartStorage,
    ) {
        
    }


    #[Route('/camera/search', name: 'camera_search')]
    public function search(Request $request, PaginatorInterface $paginator, SessionInterface $session,PriceFormatter $priceFormatter): Response
    {
        $page = $request->query->getInt('page', 1);
        $newCriteria = [
            'order' => $request->query->get('orderby') ,
            'resolution' => $request->query->get('res'),
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle') ,
            'prix' => $request->query->get('price_range') ? $priceFormatter->formatPriceRange($request->query->get('price_range')) : null,
        ];
        
        $searchCriteria = $this->cameraRepo->fillInTheSession($newCriteria, $session);
        $formattedPrice = $priceFormatter->displayFormattedPrice($searchCriteria['prix'] ?? null);
        $session->set('searchCriteria', $searchCriteria);

        $cameras = $this->callCamera->searchBy($searchCriteria);
        $data = $this->cameraRepo->pagination($cameras, $page, $paginator);
        return $this->render('client/pages/shop.html.twig', [
            'cameras' => $data,
            'categories' => $this->categorie->findAll(),
            'items' => $this->callCamera->getItems(),
            'pagination' => $this->cameraRepo->extractPaginationInfo(ceil($data->getTotalItemCount() / 9), $page),
            'route' => 'camera_search',
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
            'price'=>$formattedPrice,
        ]);
    }

    #[Route('/fetchCamera', name: 'fetch')]
    public function fetch(Request $request, SessionInterface $session): Response
    {
        $session->remove('searchCriteria');
        $page = $request->query->getInt('page', 1);
        return $this->render('client/pages/shop.html.twig', [
            'cameras' => $this->callCamera->getAllCamera($page),
            'categories' => $this->categorie->findAll(),
            'items' => $this->callCamera->getItems(),
            'pagination' => $this->cameraRepo->extractPaginationInfo(ceil($this->callCamera->getItems() / 9), $page),
            'route' => 'fetch',
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
            'price'=>'',
        ]);
    }
}
