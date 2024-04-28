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
    public function index(Request $request): Response
    {
        $form = $this->createForm(CartItemType::class);
        $form->handleRequest($request);
        return $this->render('client/pages/cart/cart.html.twig', [
            'cart' =>  $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
            'form' => $form->createView(),
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
    public function clear(Request $request){
        $this->cartStorage->clearCart($this->cartStorage->getCart());
        $request->getSession()->remove('voucher');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('update_cart' , name:'update')]
    public function update(Request $request):Response
    {
        
        $id = $request->query->get('id');
        $quantity = $request->query->get('quantity');
        $quantitys = $request->query->get('quantities');
        dd($id,$quantity,$quantitys);

        
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

    #[Route('/remove',name:'clear')]
    public function remove(Request $request){
       $session = $request->getSession();
       $session->remove('cart');
        return $this->redirectToRoute('app_cart');
    }

}
