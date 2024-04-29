<?php

namespace App\Controller;

use App\Cart\Handler\CartStorageInterface;
use App\Service\Api\Cameras\CameraFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
    private CartStorageInterface $cartStorage,
    private CameraFetcherInterface $fetcher,
    )
    {
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('client/pages/index.html.twig',[
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
            'latest'=> $this->fetcher->getLastCameras(),
            'mostOrders'=>$this->fetcher->CameratheMostOrders(),
        ]);
    }
}
