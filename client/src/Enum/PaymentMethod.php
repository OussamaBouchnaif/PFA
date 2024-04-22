<?php

namespace App\Enum;

enum PaymentMethod :string
{
    case paypal  = 'paypal ';

    case credit_card ='credit_card';
}
