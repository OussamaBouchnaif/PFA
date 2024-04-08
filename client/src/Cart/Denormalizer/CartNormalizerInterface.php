<?php

namespace App\Cart\Denormalizer;

use App\ValueObject\CartValueObject;

interface CartNormalizerInterface
{
    public function getCart():CartValueObject;

}