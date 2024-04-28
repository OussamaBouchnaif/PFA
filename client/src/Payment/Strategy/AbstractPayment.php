<?php

namespace App\Payment\Strategy;


use App\Payment\Validator\PaymentValidatorInterface;

abstract class AbstractPayment implements PaymentInterface
{
    public function __construct(
        protected PaymentValidatorInterface $validator,
    ) {}

    public function supportsMethod(string $method): bool
    {
        return $this->getSupportedMethod() === $method;
    }
}
