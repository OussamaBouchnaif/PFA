<?php

namespace App\Controller;

use App\Calculator\CalculatorContext;
use App\Calculator\TotalCalculatorInterface;
use App\Calculator\TotalCalculatorWithCoupon;
use App\Calculator\TotalCalculatorWithoutCoupon;
use App\Cart\Factory\CartFactory;
use App\Forms\CouponType;
use App\Cart\Handler\CartStorageInterface;
use App\Cart\Persister\CartPersisterInterface;
use App\Entity\CodePromo;
use App\Forms\CheckoutType;
use App\Repository\CodePromoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Pipes\PipesInterface;

class OrderController extends AbstractController
{
    public function __construct(private CartStorageInterface $cartStorage,
    private  CartFactory $cartFactory,
    private  CartPersisterInterface $cartPersister,
    private CalculatorContext $calculator)
    {
    
    }

    #[Route('/order', name: 'order')]
    public function check(Request $request,CodePromoRepository $codePromo): Response
    {
        $cart = $this->cartFactory->build();
        $session = $request->getSession();
        $formCoupon = $this->createForm(CouponType::class);
        $formOrder = $this->createForm(CheckoutType::class);
        $formCoupon->handleRequest($request);
        $formOrder->handleRequest($request);
        if($formCoupon->isSubmitted() && $formCoupon->isValid())
        {
            $code = $formCoupon->getData();
            $promoLine = $codePromo->findBy(['code'=>$code]);
            $session->set('promo',$promoLine);
        }
        if ($formOrder->isSubmitted() && $formOrder->isValid()) {
            $promoLine = $session->get('promo');
            $cart->setTotal($this->calculator->priceCalculator($this->cartStorage->getCart(),$promoLine[0]->getPourcentage()));
            $this->cartPersister->persist($cart);
            $this->cartStorage->clearCart($this->cartStorage->getCart());
             
        }
        return $this->render('client/pages/checkout.html.twig', [
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
            'totalPromo' => '',
            'formCoupon' => $formCoupon,
            'formOrder' => $formOrder->createView(),
        ]);
    }
}
