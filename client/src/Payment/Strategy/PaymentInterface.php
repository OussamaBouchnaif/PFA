<?php

namespace App\Payment\Strategy;


interface PaymentInterface
{
    public function supportsMethod(string $method): bool;
    public function getSupportedMethod(): string;
    public function getForm();
}
