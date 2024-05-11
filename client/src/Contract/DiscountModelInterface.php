<?php

namespace App\Contract;


interface DiscountModelInterface
{
    public function getDiscount(): float;

    public function getRate(): float;

    public function getType(): string;
}
