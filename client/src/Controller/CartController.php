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
        return $this->render('client/pages/cart/cart.html.twig', [
            'cart' =>  $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
    }

    #[Route('/fetchCart',name:'fatch_cart')]
    public function fetchCart()
    {
        $htmlContent = $this->renderView('client/pages/components/cartitems.html.twig', [
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
        return new JsonResponse(['html' => $htmlContent]);
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
                $this->cartStorage->addToCart($camera,$quantity,$stockage);
                return $this->redirectToRoute('fatch_cart');
            } 
        } else {
            return $this->redirectToRoute('fetch');
        }
    }
    #[Route('/clear',name:'clear')]
    public function clear(){
        $this->cartStorage->clearCart($this->cartStorage->getCart());
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/deleteCamera/{id}',name:'deletecamera')]
    public function deleteCamera(int $id,Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $this->cartStorage->removeFromCart($id);
            $htmlContent = $this->renderView('client/pages/components/cartitems.html.twig', [
                'cart' => $this->cartStorage->getCart(),
                'totalItems' => $this->cartStorage->TotalPriceItems(),
            ]);
            
            return new JsonResponse(['success' => true, 'html' => $htmlContent]);
        }
    
        return new JsonResponse(['success' => false, 'message' => 'Invalid request.'], 400);
    }

}
