<?php

namespace App\Payment\Strategy;

use App\Entity\Paiement;
use App\Enum\PaymentStatus;
use App\Forms\PaypalType;
use App\Payment\Strategy\AbstractPayment;

class PaypalePayment extends AbstractPayment
{
    public function pay(Paiement $payment)
    {
       /*  $payment->setMethode("PAYPAL");
        $payment->setDatePaiement(new \DateTimeImmutable());
        $payment->setStatus(PaymentStatus::Processed); */
        dd('paypal');
    }
    
    public function getSupportedMethod(): string
    {
        return 'paypal';
    }

    public function getForm()
    {
        return PaypalType::class;
    }
}
