<?php

namespace App\Payment\Factory;

use App\Entity\Cart;
use App\Entity\Paiement;
use App\Enum\PaymentStatus;
use Doctrine\ORM\EntityManagerInterface;

class PaymentFactory
{
    public function __construct(private EntityManagerInterface $manager)
    {
        
    }
    public function createPayment(string $method, Cart $cart):void
    {
        
        $payment = $this->createPaymentInstance($method, $cart);

        $this->manager->persist($payment);
        $this->manager->flush();
        
        
    }

    private function createPaymentInstance(string $method, Cart $cart):Paiement
    {
        $payment = new Paiement();
        $payment->setMethode($method)
            ->setDatePaiement(new \DateTimeImmutable())
            ->setStatus(PaymentStatus::Processed)
            ->setCart($cart)
            ->setMontant($cart->getTotal());
        return $payment;
    }
    

}
