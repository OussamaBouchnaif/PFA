<?php

namespace App\Payment;

use App\Entity\Cart;
use App\Entity\Paiement;
use App\Payment\Strategy\PaymentInterface;


class PaymentManager
{
    public function __construct(private iterable  $paymentProcessors
    ) {
        
    }

    public function getPaymentStrategy(string $method): PaymentInterface
    {
        foreach ($this->paymentProcessors as $processor) {
            if ($processor->supportsMethod($method)) {
                return $processor;
            }
        }
        throw new \Exception("No payment processor supports the method: $method");
    }


   
}
