<?php

namespace App\Cart\Handler;

use App\Cart\Handler\CartStorageInterface;
use App\Reduction\Applier\AbstractDiscountApplier;

abstract class AbstractCartStorage implements CartStorageInterface
{
    public function __construct(protected AbstractDiscountApplier $applier)
    {
        
    }

}
