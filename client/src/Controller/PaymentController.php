<?php

namespace App\Controller;

use App\Cart\Factory\CartFactory;
use App\Cart\Handler\CartStorageInterface;
use App\Payment\Factory\PaymentFactory;
use App\Payment\PaymentManager;
use App\Processor\CartProcessor;
use App\Voucher\VoucherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    public function __construct(
        private PaymentManager $manager,
        private CartStorageInterface $cartStorage,
        private CartProcessor $cartProcessor,
        private CartFactory $cartFactory,
        private VoucherInterface $voucherManager,
        private PaymentFactory $paymentFactory,
    ) {
    }

    #[Route('/payment', name: 'app_payment')]
    public function index(Request $request): Response
    {
        $cart = $this->cartFactory->build();
        $session = $request->getSession();
        $startegy = $session->get('payment');
        $paymentStrategy = $this->manager->getPaymentStrategy($startegy);
        $formPayment = $this->createForm($paymentStrategy->getForm());

        $formPayment->handleRequest($request);
        if ($formPayment->isSubmitted() && $formPayment->isValid()) {
            $voucherIdentifier = $this->voucherManager->getVoucherIdentifier();
            $this->cartProcessor->process($cart, $voucherIdentifier);
            $this->paymentFactory->createPayment($startegy, $cart);

            return $this->redirectToRoute('done');
        }

        return $this->render('client/payment/index.html.twig', [
            'form' => $formPayment->createView(),
            'strategy' => $startegy,
        ]);
    }

    #[Route('/process', name: 'done')]
    public function done(Request $request)
    {
        $session = $request->getSession();
        $session->remove('voucher');
        $this->cartStorage->clearCart($this->cartStorage->getCart());

        return $this->redirectToRoute('app_home');
    }
}
