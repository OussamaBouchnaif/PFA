<?php

namespace App\Controller;


use App\Formatter\PriceFormatter;

use App\Repository\CameraRepository;
use App\Repository\CategorieRepository;
use App\Cart\Handler\CartStorageInterface;
use App\Reduction\Manager\ReductionInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Api\Cameras\CameraFetcherInterface;
use App\Service\Pagination\PaginationServiceInterface;
use App\Service\PriceCalculation\PriceCalculationInterface;
use App\Service\Session\SessionManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    public function __construct(
        private CategorieRepository $categorie,
        private CameraFetcherInterface $cameraFetcher,
        private CartStorageInterface $cartStorage,
        private SessionManagerInterface $sessionManager,
        private PaginationServiceInterface $paginationManager,
        private PriceCalculationInterface $priceCalculation,
    ) {
    }


    #[Route('/camera/search', name: 'camera_search')]
    public function search(Request $request, PriceFormatter $priceFormatter): Response
    {
        $page = $request->query->getInt('page', 1);
        $session = $request->getSession();
        $newCriteria = [
            'order' => $request->query->get('orderby'),
            'resolution' => $request->query->get('res'),
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle'),
            'prix' => $request->query->get('price_range') ? $priceFormatter->formatPriceRange($request->query->get('price_range')) : null,
        ];

        $searchCriteria = $this->sessionManager->fillInTheSession($newCriteria, $session);
        $session->set('searchCriteria', $searchCriteria);

        $cameras = $this->cameraFetcher->searchBy($searchCriteria);
        $data = $this->paginationManager->paginate($cameras, $page,);
        $pricingDetails = $this->priceCalculation->applyDiscounts($cameras);
        if ($request->isXmlHttpRequest()) {

            return $this->render('client/pages/components/cameras.html.twig', [
                'cameras' => $data,
                'pricingDetails' => $pricingDetails,
                'categories' => $this->categorie->findAll(),
                'items' => $this->cameraFetcher->getItems(),
                'pagination' => $this->paginationManager->extractPaginationInfo($data->getTotalItemCount(), $page,),
                'cart' => $this->cartStorage->getCart(),
                'totalItems' => $this->cartStorage->TotalPriceItems(),
            ]);
        }
    }

    #[Route('/fetchCamera', name: 'fetch')]
    public function fetch(Request $request, SessionInterface $session): Response
    {
        $session->remove('searchCriteria');
        $page = $request->query->getInt('page', 1);
        $cameras = $this->cameraFetcher->getAllCamera($page);
        $pricingDetails = $this->priceCalculation->applyDiscounts($cameras);

        return $this->render('client/pages/shop.html.twig', [
            'cameras' =>$cameras ,
            'pricingDetails' => $pricingDetails,
            'categories' => $this->categorie->findAll(),
            'items' => $this->cameraFetcher->getItems(),
            'pagination' => $this->paginationManager->extractPaginationInfo($this->cameraFetcher->getItems(), $page,),
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
    }
}
