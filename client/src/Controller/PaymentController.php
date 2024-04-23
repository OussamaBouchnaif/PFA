<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Event\OrderPlacedEvent;
use App\Payment\PaymentManager;
use App\Processor\CartProcessor;
use App\Cart\Factory\CartFactory;
use App\Voucher\VoucherInterface;
use App\ValueObject\CartValueObject;
use App\Payment\Factory\PaymentFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{

    public function __construct(
        private PaymentManager $manager,
        private CartStorageInterface $cartStorage,
        private CartProcessor $cartProcessor,
        private CartFactory $cartFactory,
        private VoucherInterface $voucherManager,
        private PaymentFactory $paymentFactory,
        private EventDispatcherInterface $eventDispatcher,
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

            // Dispatch the event
            $event = new OrderPlacedEvent($cart->getItems());
            $this->eventDispatcher->dispatch($event, OrderPlacedEvent::NAME);
            
            return $this->redirectToRoute('done');
           
        }
        return $this->render('client/payment/index.html.twig', [
            'form' => $formPayment->createView(),
            'strategy' => $startegy,
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
    }
    
    #[Route('/done',name:'done')]
    public function done(Request $request)
    {
        $session = $request->getSession();
        $session->remove('voucher');
        $this->cartStorage->clearCart($this->cartStorage->getCart());

        return $this->redirectToRoute('app_home');
    }
}
