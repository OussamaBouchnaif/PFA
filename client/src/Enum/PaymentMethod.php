<?php

namespace App\Enum;

enum PaymentMethod :string
{
    case paypal  = 'paypal ';

    case cart_credit ='cart_credit';
}
