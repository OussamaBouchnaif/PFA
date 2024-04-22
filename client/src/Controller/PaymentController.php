<?php

namespace App\Controller;

use App\Payment\PaymentManager;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{

    public function __construct(private PaymentManager $manager,
    private CartStorageInterface $cartStorage,)
    {
    }

    #[Route('/payment', name: 'app_payment')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $startegy = $session->get('payment');
        $paymentStrategy = $this->manager->getPaymentStrategy($startegy);
        $formPayment = $this->createForm($paymentStrategy->getForm());


         /*  $voucherIdentifier = $voucherManager->getVoucherIdentifier();
        $cartProcessor->process($cart, $voucherIdentifier);
        $session->remove('voucher'); */


        return $this->render('client/payment/index.html.twig', [
            'form'=> $formPayment->createView(),
            'strategy'=> $startegy,
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
    }
}
