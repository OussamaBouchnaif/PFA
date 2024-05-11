<?php

namespace App\Service\PriceCalculation;

use App\DTO\CameraDTO;
use App\Entity\Camera;
use App\ValueObject\CameraPriceValueObject;

interface PriceCalculationInterface
{

    public function prepareCameraPricingDetails(int $id): CameraPriceValueObject;

    public function applyDiscounts(array $cameras): array;

    public function loadCamera(int $id): camera;
}
