<?php

namespace App\Service\PriceCalculation;


use App\Entity\Camera;
use App\Entity\CameraPrice;

interface PriceCalculationInterface
{

    public function prepareCameraPricingDetails(int $id): CameraPrice;

    public function applyDiscounts(array $cameras): array;

    public function loadCamera(int $id): camera;
}
