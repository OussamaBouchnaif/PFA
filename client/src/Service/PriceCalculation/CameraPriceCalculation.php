<?php

namespace App\Service\PriceCalculation;

use App\DTO\CameraDTO;
use App\Entity\Camera;
use App\ValueObject\CameraPriceValueObject;
use App\Reduction\Manager\ReductionInterface;
use App\Reduction\Manager\Strategy\AbstractReductionStrategy;
use Doctrine\ORM\EntityManagerInterface;

class CameraPriceCalculation implements PriceCalculationInterface
{
    public function __construct(
        private ReductionInterface $manager,
        private AbstractReductionStrategy $strategy,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function prepareCameraPricingDetails(int $id): CameraPriceValueObject
    {
        $camera = $this->loadCamera($id);
        $discountModel = $this->strategy->getReductionModel($camera);
        $discountedCamera = $this->manager->getDiscountedCamera($camera, $discountModel);

        $originalPrice = $camera->getPrix();
        $discountedPrice = $discountedCamera->getTotal();
        $discountValue = $originalPrice - $discountedPrice;
        $discountRate = $discountedCamera->getDiscountRate();

        return new CameraPriceValueObject($originalPrice, $discountedPrice, $discountValue, $discountRate);
    }

    public function applyDiscounts(array $cameras): array
    {
        $details = [];
        foreach ($cameras as $camera) {
            $details[$camera->getId()] = $this->prepareCameraPricingDetails($camera->getId());
        }
        return $details;
    }

    public function loadCamera(int $id): camera
    {
        return $this->entityManager->getRepository(Camera::class)->find($id);
    }
}
