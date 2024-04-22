<?php

namespace App\Payment\Strategy;

use App\Entity\Cart;
use App\Entity\Paiement;
use App\Enum\PaymentMethod;
use App\Enum\PaymentStatus;
use App\Forms\CreditCardType;
use App\Payment\Strategy\AbstractPayment;

class CreditCartPayment extends AbstractPayment
{

    public function getSupportedMethod(): string
    {
        return 'credit_card';
    }
    public function getForm()
    {
        return CreditCardType::class;
    }
}
