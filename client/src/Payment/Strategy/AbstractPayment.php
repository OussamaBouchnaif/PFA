<?php

namespace App\Payment\Strategy;

abstract class AbstractPayment implements PaymentInterface
{

    public function supportsMethod(string $method): bool
    {
        return $this->getSupportedMethod() === $method;
    }
}
