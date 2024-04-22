<?php

namespace App\Payment\Strategy;

use App\Entity\Cart;
use App\Entity\Paiement;

interface PaymentInterface
{
    public function supportsMethod(string $method): bool;
    public function getSupportedMethod(): string;
    public function getForm();
}
