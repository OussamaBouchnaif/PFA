<?php

namespace App\Controller;

use App\Forms\CheckoutType;
use App\Cart\Factory\CartFactory;
use App\Voucher\VoucherInterface;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private CartFactory $cartFactory,
        private RequestStack $stack,

    ) {
    }

    #[Route('/order', name: 'order')]
    public function check(
        Request $request,
        VoucherInterface $voucherManager,
        Security $security
    ): Response {

        $requestt = $this->stack->getCurrentRequest();
        if (!$security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $request->getSession()->set('referer', $requestt->getUri());
            return $this->redirectToRoute('app_login');
        }

        $cart = $this->cartFactory->build();
        $formOrder = $this->createForm(CheckoutType::class);
        $formOrder->handleRequest($request);

        $session = $request->getSession();
        if ($formOrder->isSubmitted() && $formOrder->isValid()) {
            if ($formOrder->getClickedButton() && 'applyVoucher' === $formOrder->getClickedButton()->getName()) {
                $voucherCode = $formOrder->get('voucher')->getData();
                $voucherManager->applyVoucher($voucherCode, $cart);
                $voucherData = [
                    'voucher' => $voucherCode,
                    'discount' => $voucherManager->applyVoucher($voucherCode, $cart)->getTotal(),
                    'rate' => $voucherManager->applyVoucher($voucherCode, $cart)->getDiscountRate(),
                ];
                $session->set('voucher', $voucherData);
            }
            if ($formOrder->getClickedButton() && 'placeOrder' === $formOrder->getClickedButton()->getName()) {
                $session->set('payment', $formOrder->getData()['payment']);

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
