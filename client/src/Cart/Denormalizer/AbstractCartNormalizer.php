<?php


namespace App\Cart\Denormalizer;

use App\Cart\Denormalizer\CartNormalizerInterface;
use App\Cart\Handler\CartStorageInterface;

abstract class AbstractCartNormalizer implements CartNormalizerInterface
{
    protected CartStorageInterface $cartStorage;

    public function __construct(CartStorageInterface $cartStorage)
    {
        $this->cartStorage = $cartStorage;
    }
}
