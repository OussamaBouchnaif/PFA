<?php

namespace App\Enum;

enum PaymentStatus :string
{
    case Pending  = 'Pending ';

    case Processed ='Processed';

    case Failed  ='Failed ';
    
    case Refunded   ='Refunded  ';
}
