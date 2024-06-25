<?php

namespace App\Controller;

use App\Forms\CheckoutType;
use App\Cart\Factory\CartFactory;
use App\Voucher\VoucherInterface;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class OrderController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private CartFactory $cartFactory,
        private UrlGeneratorInterface $generator,

    ) {
    }

    #[Route('/order', name: 'order')]
    public function check(
        Request $request,
        VoucherInterface $voucherManager,
    ): Response {
        $cart = $this->cartFactory->build();
        $formOrder = $this->createForm(CheckoutType::class);
        $formOrder->handleRequest($request);

        $session = $request->getSession();
        if ($formOrder->isSubmitted() && $formOrder->isValid()) {
            if ($formOrder->getClickedButton() && 'applyVoucher' === $formOrder->getClickedButton()->getName()) {
                $voucherCode = $formOrder->get('voucher')->getData();
                $voucherData = [
                    'voucher' => $voucherCode,
                    'discount' => $voucherManager->applyVoucher($voucherCode, $cart)->getTotal(),
                    'rate' => $voucherManager->applyVoucher($voucherCode, $cart)->getDiscountRate(),
                ];
                $session->set('voucher', $voucherData);
            }
            if ($formOrder->getClickedButton() && 'placeOrder' === $formOrder->getClickedButton()->getName()) {

                $session->set('payment', $formOrder->getData()['payment']);
                if (count($cart->getItems()) === 0) {
                    $this->addFlash(
                        'warning',
                        'the cart is empty'
                    );
                    return $this->redirectToRoute('order');
                }
                return $this->redirectToRoute('app_payment');
            }
        }

        return $this->render('client/pages/checkout.html.twig', [
            'formOrder' => $formOrder->createView(),
            'voucher' => $session->get('voucher')['voucher'] ?? null,
            'amount' => $cart->computeTotal(),
            'discount' => $session->get('voucher')['discount'] ?? null,
            'rate' => $session->get('voucher')['rate'] ?? null,
        ]);
    }
}
