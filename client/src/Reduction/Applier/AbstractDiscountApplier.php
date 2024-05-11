<?php

namespace App\Reduction\Applier;

use App\Entity\Camera;
use App\ValueObject\CartItemValueObject;
use Doctrine\ORM\EntityManagerInterface;
use App\Reduction\Manager\ReductionInterface;
use App\Reduction\Manager\Strategy\AbstractReductionStrategy;

abstract class AbstractDiscountApplier
{

    public function __construct(
        protected AbstractReductionStrategy $strategy,
        protected ReductionInterface $manager,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    abstract public function applyDiscount(CartItemValueObject $item): CartItemValueObject;
    
    abstract public function loadCamera(int $id):Camera;
}
