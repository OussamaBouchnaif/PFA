<?php

namespace App\Service\Api\Cameras;

interface CameraFatcherInterface
{
    public function getAllCamera(int $page):array;
    public function getCameraById(int $id);
    public function getItems():int;
    public function searchBy(array $searchCriteria): array;
}
