<?php

namespace App\Cart\Denormalizer;

use App\Cart\Handler\CartStorageInterface;

interface CartNormalizerInterface
{
    public function getCartInfo();
    public function getCartLines();
}