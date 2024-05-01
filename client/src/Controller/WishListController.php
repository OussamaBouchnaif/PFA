<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Entity\FavoritCamera;
use Doctrine\ORM\EntityManagerInterface;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Api\Cameras\CameraFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WishListController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private CameraFetcherInterface $fetcher,
        private EntityManagerInterface $manager,
        private Security $security,
    )
    {
    }
    
    #[Route('/wish/list', name: 'app_wish_list')]
    public function index(): Response
    {
        
        return $this->render('client/pages/wish_list/index.html.twig', [
            'controller_name' => 'WishListController',
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
    }

    #[Route('/add/{id}', name:'add')]
    public function addWishList(Camera $camera):Response
    {
        if (!$this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }
        $this->manager->getRepository(FavoritCamera::class)->addToWishlist($camera,$this->security->getUser());
        return new JsonResponse(['success' => true]);
    }
}
