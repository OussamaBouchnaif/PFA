<?php

namespace App\Payment\Strategy;

use App\Entity\Paiement;
use App\Forms\CreditCardType;
use App\Payment\Strategy\AbstractPayment;

class CreditCartPayment extends AbstractPayment
{
    public function pay(Paiement $payment)
    {
        dd('CreditCardType');
    }
    
    public function getSupportedMethod(): string
    {
        return 'credit_card';
    }
    public function getForm()
    {
        return CreditCardType::class;
    }
}
