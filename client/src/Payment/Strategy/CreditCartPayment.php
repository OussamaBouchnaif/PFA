<?php

namespace App\Payment\Strategy;


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
