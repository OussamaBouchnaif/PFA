<?php

namespace App\Payment;

use App\Payment\Processor\PaymentProcessorInterface;

class PaymentProcessorSelector
{
    public function __construct(
        private iterable  $paymentProcessors
    ) {
    }

    public function getPaymentProcessor(string $method): PaymentProcessorInterface
    {
        foreach ($this->paymentProcessors as $processor) {
            if ($processor->supportsMethod($method)) {
                return $processor;
            }
        }
        throw new \Exception("No payment processor supports the method: $method");
    }
}
