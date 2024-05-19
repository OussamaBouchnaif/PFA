<?php

namespace App\Controller;

use App\Cart\Factory\CartFactory;
use App\Cart\Handler\CartStorageInterface;
use App\Payment\PaymentMethodeSelector;
use App\Payment\PaymentProcessorSelector;
use App\Processor\CartProcessor;
use App\Voucher\VoucherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private CartProcessor $cartProcessor,
        private CartFactory $cartFactory,
        private VoucherInterface $voucherManager,
        private PaymentProcessorSelector $process,
    ) {
    }

    #[Route('/payment', name: 'app_payment')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $startegy = $session->get('payment');

        return $this->redirect($this->process->getPaymentProcessor($startegy)->getPaymentGateWay());
    }

    #[Route('/success', name: 'app_success')]
    public function success(Request $request): Response
    {
        $cart = $this->cartFactory->build();
        $session = $request->getSession();
        $voucherIdentifier = $this->voucherManager->getVoucherIdentifier();
        $this->cartProcessor->process($cart, $voucherIdentifier);

        $this->voucherManager->invalidateVoucher($voucherIdentifier);
        $session->remove('voucher');
        $this->cartStorage->clearCart($this->cartStorage->getCart());

        return $this->redirectToRoute('app_home');
    }


    #[Route('/cancel', name: 'app_cancel')]
    public function cancel(): Response
    {
        dd("cancel");
    }

   
}
