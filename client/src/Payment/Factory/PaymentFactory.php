<?php

namespace App\Payment\Factory;

use App\Entity\Cart;
use App\Entity\Paiement;
use App\Enum\PaymentStatus;
use App\Payment\PaymentManager;
use Doctrine\ORM\EntityManagerInterface;

class PaymentFactory
{
    public function __construct(private EntityManagerInterface $manager, private PaymentManager $paymentManager)
    {
        
    }
    public function createPayment(string $method, Cart $cart):void
    {
        $payment = new Paiement();
        $this->pay($method, $payment, $cart);
        $this->manager->persist($payment);
        $this->manager->flush();
        
    }

    private function pay(string $method, Paiement $payment, Cart $cart)
    {
        $payment->setMethode($method)
            ->setDatePaiement(new \DateTimeImmutable())
            ->setStatus(PaymentStatus::Processed)
            ->setCart($cart)
            ->setMontant($cart->getTotal());
    }
    

}
