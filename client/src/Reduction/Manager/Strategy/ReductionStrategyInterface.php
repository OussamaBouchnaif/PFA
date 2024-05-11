<?php

namespace App\Reduction\Manager\Strategy;

use App\Contract\DiscountModelInterface;
use App\Entity\Camera;

interface ReductionStrategyInterface
{
    public function getReductionModel(Camera $camera):DiscountModelInterface;

    public  function loadReduction(Camera $camera);

    public function getType();

    public function supportsType(string $type): bool;
        
}
