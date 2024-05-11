<?php

namespace App\Reduction\Manager;

use App\Entity\Camera;
use App\Contract\DiscountModelInterface;
use App\Contract\DiscountedObjectInterface;

class DefaultReduction implements ReductionInterface
{
    public function getDiscountedCamera(Camera $camera, ?DiscountModelInterface $reduction): DiscountedObjectInterface
    {
        return new class($camera, $reduction) implements DiscountedObjectInterface
        {
            private Camera $camera;
            private ?DiscountModelInterface $reduction;

            public function __construct(Camera $camera, ?DiscountModelInterface $reduction)
            {
                $this->camera = $camera;
                $this->reduction = $reduction;
            }

            public function getTotal(): float
            {
                $price = $this->camera->getPrix();
                return null === $this->reduction ? $price : $price * (1  - $this->reduction->getDiscount());
            }

            public function getDiscountValue(): float
            {
                $price = $this->camera->getPrix();
                return null === $this->reduction ? 0.0 : $price * $this->reduction->getDiscount();
            }

            public function getDiscountRate():float
            {
                return $this->reduction->getRate();
            }

            public function getDiscountType(): string
            {
                return $this->reduction->getType();
            }
        };
    }
}
