<?php

namespace App\Payment\Validator;

use App\Entity\Paiement;
use App\Payment\Validator\PaymentValidatorInterface;


class BasicValidator implements PaymentValidatorInterface
{
    public function validate(Paiement $payment):bool
    {
        if ($payment->getMontant() <= 0) {
            return false;
        }
        return true;
    }
}
