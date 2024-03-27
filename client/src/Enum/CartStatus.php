<?php

namespace App\Enum;

enum CartStatus: string
{
    case placed = 'placed';

    case cancelled = 'cancelled';

    case new = 'new';
}
