<?php

namespace App\Payment\Strategy;

use App\Entity\Cart;
use App\Entity\Paiement;
use App\Enum\PaymentMethod;
use App\Forms\PaypalType;
use App\Enum\PaymentStatus;
use App\Payment\Strategy\AbstractPayment;

class PaypalePayment extends AbstractPayment
{

    public function getSupportedMethod(): string
    {
        return 'paypal';
    }

    public function getForm()
    {
        return PaypalType::class;
    }
}
