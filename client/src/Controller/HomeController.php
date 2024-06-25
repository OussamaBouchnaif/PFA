<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Api\Cameras\CameraFetcherInterface;
use App\Service\PriceCalculation\PriceCalculationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

class HomeController extends AbstractController
{
    public function __construct(
        private CameraFetcherInterface $fetcher,
        private PriceCalculationInterface $priceCalculation,
    ) {
    }

    #[Route('/', name: 'app_home')]
    #[Cache(smaxage: 3600, public: true,mustRevalidate:true)]
    public function index(): Response
    {
        $last =$this->fetcher->getLastCameras();
        $mostOrders = $this->fetcher->CameratheMostOrders();
        $pricingDetailsLatest = $this->priceCalculation->applyDiscounts($last);
        $pricingDetailsMost = $this->priceCalculation->applyDiscounts($mostOrders);

        
        return $this->render('client/pages/index.html.twig', [
            'latest' => $last,
            'mostOrders' => $mostOrders ,
            'pricingDetailsLatest' => $pricingDetailsLatest,
            'pricingDetailsMost' => $pricingDetailsMost,
        ]);
    }
}
