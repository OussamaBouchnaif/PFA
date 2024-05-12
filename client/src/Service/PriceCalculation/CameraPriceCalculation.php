<?php

namespace App\Service\PriceCalculation;

use App\Entity\Camera;
use App\Entity\CameraPrice;
use Doctrine\ORM\EntityManagerInterface;
use App\Reduction\Manager\ReductionInterface;
use App\Reduction\Manager\Strategy\AbstractReductionStrategy;

class CameraPriceCalculation implements PriceCalculationInterface
{
    public function __construct(
        private ReductionInterface $manager,
        private AbstractReductionStrategy $strategy,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function prepareCameraPricingDetails(int $id): CameraPrice
    {
        $camera = $this->loadCamera($id);
        $discountModel = $this->strategy->getReductionModel($camera);
        $discountedCamera = $this->manager->getDiscountedCamera($camera, $discountModel);

        $originalPrice = $camera->getPrix();
        $discountedPrice = $discountedCamera->getTotal();
        $discountValue = $originalPrice - $discountedPrice;
        $discountRate = $discountedCamera->getDiscountRate();

        return new CameraPrice($originalPrice, $discountedPrice, $discountValue, $discountRate);
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
