<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Entity\CartItem;
use App\Forms\CartItemType;
use App\Repository\CameraRepository;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private CartStorageInterface $cartStorage;
    private CameraRepository $camRepo;
    public function __construct(CartStorageInterface $cartStorage,CameraRepository $camRepo)
    {
        $this->cartStorage = $cartStorage;
        $this->camRepo = $camRepo;
    }
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cartData = $this->cartStorage->getCart();
        return $this->render('client/pages/cart/cart.html.twig', [
            'cart' => $cartData,
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
    }
    #[Route('/addToCart',name:'addtocart')]
    public function addToCart(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $quantity = $request->request->get('quantity');
            $idcamera = $request->request->get('idcamera');
            $stockage = $request->request->get('stockage');
            if (!empty($quantity) && !empty($idcamera) && !empty($stockage)) {
                
                $camera = $this->camRepo->findCameraWithImages($idcamera);
                $cartItem = new CartItem($camera, $quantity, $stockage);
                $this->cartStorage->addToCart($cartItem);
                $htmlContent = $this->renderView('client/pages/components/cartitems.html.twig', [
                    'cart' => $this->cartStorage->getCart(),
                    'totalItems' => $this->cartStorage->TotalPriceItems(),
                ]);
                return new JsonResponse(['html' => $htmlContent]);
            } 
        } else {
            return $this->redirectToRoute('fetch');
        }
    }
    #[Route('/clear',name:'clear')]
    public function clear(Request $request){
        $request->getSession()->remove('cart');
        return $this->redirectToRoute('fetch');
    }

    #[Route('/deleteCamera/{id}',name:'deletecamera')]
    public function deleteCamera(CartItem $cartItem)
    {
        dd($cartItem);
    }

}
