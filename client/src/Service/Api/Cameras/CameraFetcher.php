<?php

namespace App\Service\Api\Cameras;

use App\Service\Api\Cameras\AbstractCameraFetcher;
use App\Service\Api\Exception\ObjectNotFoundException;

class CameraFetcher extends AbstractCameraFetcher
{

    public function getAllCamera(int $page): array
    {
        /* $this->clearCache(); */
        return $this->getCameraData('api/cameras?page=' . $page);
    }

    public function getCameraById(int $id)
    {
        $response = $this->getData->getDataFromApi("/api/cameras/" . $id);
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!');
        }
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO', 'json');
    }

    public function getItems(): int
    {
        $items = $this->getData->getTotalItems("api/cameras/");
        return $items;
    }

    public function getLastCameras():array
    {
        $response =  $this->getData->getDataFromApi("api/cameras/latest");
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!');
        }
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO[]', 'json');
    }

    public function searchBy(array $searchCriteria): array
    {
        $queryString = $this->queryStringBuilder->addAngleVision($searchCriteria['angleVision'] ?? null)
            ->addCategorieNameParameter($searchCriteria['categorie.nom'] ?? null)
            ->addPriceRangeParameter($searchCriteria['prix'] ?? null)
            ->addResolution($searchCriteria['resolution'] ?? null)
            ->addOrder($searchCriteria['order'] ?? null);
        return $this->getCameraData('api/cameras/?' . $queryString->getQueryString());
    }

    public function CameratheMostOrders():array
    {
        $response =  $this->getData->getDataFromApi("api/cameras/mostOrders");
        /*  if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!');
        } */
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO[]', 'json');
    }

    public function getRelatedCameras(int $id):array
    {
        $response =  $this->getData->getDataFromApi("api/cameras/".$id."/related");
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO[]', 'json');
    }


}
