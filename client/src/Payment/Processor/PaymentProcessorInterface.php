<?php

namespace App\Payment\Processor;

interface PaymentProcessorInterface
{
    public function processPayment();

    public function supportsMethod(string $method): bool;

    public function getSupportedMethod(): string;

    public function getPaymentGateWay():string;

    public function onSuccess();
    
    public function onCancel();
}
