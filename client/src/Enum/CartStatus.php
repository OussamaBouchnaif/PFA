<?php

namespace App\Enum;

enum CartStatus: string
{
    case placed = 'placed';

    case cancelled = 'cancelled';

    case new = 'new';

    case pending = 'pending';

    public function getValue(): string
    {
        return $this->value;
    }
}
