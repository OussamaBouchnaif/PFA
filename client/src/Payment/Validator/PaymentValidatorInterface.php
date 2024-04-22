<?php

namespace App\Payment\Validator;

use App\Entity\Paiement;

interface PaymentValidatorInterface
{
    /* 
        amount validation 
    */
    public function validate(Paiement $paiement):bool;
}
