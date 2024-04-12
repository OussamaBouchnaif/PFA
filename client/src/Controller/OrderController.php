<?php

namespace App\Controller;


use App\Cart\Factory\CartFactory;
use App\Cart\Handler\CartStorageInterface;
use App\Forms\CheckoutType;
use App\Processor\CartProcessor;
use App\Voucher\VoucherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private  CartFactory $cartFactory,
    ) {
    
    }

    #[Route('/order', name: 'order')]
    public function check(
        Request $request,
        VoucherInterface $voucherManager,
        CartProcessor $cartProcessor,
    ): Response {
        $cart = $this->cartFactory->build();
        $formOrder = $this->createForm(CheckoutType::class);
        $formOrder->handleRequest($request);

        $voucherCode = $discountedCart = null;

        if ($formOrder->isSubmitted() && $formOrder->isValid()) {

            if ($formOrder->getClickedButton() && 'applyVoucher' === $formOrder->getClickedButton()->getName()) {
                $voucherCode = $formOrder->get('voucher')->getData();
                $discountedCart = $voucherManager->applyVoucher($voucherCode, $cart);
            }

            if ($formOrder->getClickedButton() && 'placeOrder' === $formOrder->getClickedButton()->getName()) {
                $voucherIdentifier = $voucherManager->getVoucherIdentifier();

                $cartProcessor->process($cart, $voucherIdentifier);

                return $this->redirectToRoute('app_home');
            }

        }

        return $this->render('client/pages/checkout.html.twig', [
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
            'totalPromo' => '',
            'formOrder' => $formOrder->createView(),
            'is_voucher_applied' => $voucherManager->isAlreadyApplied($voucherCode, $cart),
            'voucher' => $voucherCode,
            'amount' => $cart->computeTotal(),
            'discount' => null !== $discountedCart ? $discountedCart?->getTotal() : $cart->computeTotal(),
            'rate' => null !== $discountedCart ? $discountedCart?->getDiscountRate() : 0,
        ]);
    }
}
