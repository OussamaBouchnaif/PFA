<?php

namespace App\Reduction\Applier;

use App\Entity\Camera;
use App\ValueObject\CartItemValueObject;

class DefaultApplier extends AbstractDiscountApplier
{

    public function applyDiscount(CartItemValueObject $item): CartItemValueObject
    {
        $camera = $this->loadCamera($item->getId());
        $discountedCamera = $this->manager->getDiscountedCamera($camera, $this->strategy->getReductionModel($camera));
        $item->setPrice($discountedCamera->getTotal());

        return $item;
    }

    public function loadCamera(int $id): Camera
    {
        return $this->entityManager->getRepository(Camera::class)->find($id);
    }
}
