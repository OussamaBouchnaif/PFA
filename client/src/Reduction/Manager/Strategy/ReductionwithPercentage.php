<?php

namespace App\Reduction\Manager\Strategy;

use App\Contract\DiscountModelInterface;
use App\Entity\Camera;
use App\Entity\Reduction;

class ReductionwithPercentage extends AbstractReductionStrategy
{

    public  function getReductionModel(Camera $camera):DiscountModelInterface
    {
        $adaptedReduction = $this->loadReduction($camera);

        return new class($adaptedReduction) implements DiscountModelInterface{
            private ?Reduction $object;

            public function __construct(?Reduction $reduction)
            {
                $this->object = $reduction;
            }
            public function getDiscount(): float
            {
                return 0.01 * $this->getRate();
            }

            public function getRate(): float
            {
                return null === $this->object ? 0 : $this->object->getPoucentage();
            }

            public function getType(): string
            {
                return $this->getType();
            }
 
        };
    }


    public function getType():string
    {
        return 'Pourcentage';
    }
}
