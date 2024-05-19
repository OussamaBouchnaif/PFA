<?php

namespace App\Payment\Processor;

use App\Payment\Processor\PaymentProcessorInterface;

abstract class AbstractPaymentProcessor implements PaymentProcessorInterface
{
    public function __construct(
        protected string $successUrl,
        protected string $cancelUrl,
        )
    {
        
    }
    public function supportsMethod(string $method): bool
    {
        return $this->getSupportedMethod() === $method;
    }

    public function onSuccess()
    {
        return $this->successUrl;
    }
    
    public function onCancel()
    {
        return $this->cancelUrl;
    }
}
