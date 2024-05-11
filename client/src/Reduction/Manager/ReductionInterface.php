<?php

namespace App\Reduction\Manager;

use App\Entity\Camera;
use App\Contract\DiscountModelInterface;
use App\Contract\DiscountedObjectInterface;

interface ReductionInterface
{
    public function getDiscountedCamera(Camera $camera,?DiscountModelInterface $reduction):DiscountedObjectInterface;
}
