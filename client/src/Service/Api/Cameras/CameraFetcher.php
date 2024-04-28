<?php

namespace App\Service\Api\Cameras;

use App\Service\Api\Cameras\AbstractCameraFetcher;
use App\Service\Api\Exception\ObjectNotFoundException;

class CameraFetcher extends AbstractCameraFetcher
{
    /*
        get All cameras 
     */
    public function getAllCamera(int $page): array
    {
        return $this->getCameraData('api/cameras?page=' . $page);
    }

    /*
        get a specific camera using its ID
     */
    public function getCameraById(int $id)
    {
        $response = $this->getData->getDataFromApi("/api/cameras/" . $id);
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!');
        }
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO', 'json');
    }

    /*
        get number of cameras  
     */
    public function getItems(): int
    {
        $items = $this->getData->getTotalItems("api/cameras/");
        return $items;
    }

    /*
        get last 5 cameras 
     */
    public function getLastCameras()
    {
        $response =  $this->getData->getDataFromApi("api/cameras/latest");
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!');
        }
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO[]', 'json');
    }

    /*
        Search for cameras using various criteria
     */
    public function searchBy(array $searchCriteria): array
    {
        $queryString = $this->queryStringBuilder->addAngleVision($searchCriteria['angleVision'] ?? null)
            ->addCategorieNameParameter($searchCriteria['categorie.nom'] ?? null)
            ->addPriceRangeParameter($searchCriteria['prix'] ?? null)
            ->addResolution($searchCriteria['resolution'] ?? null)
            ->addOrder($searchCriteria['order'] ?? null);
        return $this->getCameraData('api/cameras/?' . $queryString->getQueryString());
    }

    /* 
        return the cameras the most orders  
   */
    public function CameratheMostOrders()
    {
        $response =  $this->getData->getDataFromApi("api/cameras/mostOrders");
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!');
        }
        return $this->denormalizer->dataDenormalizer($response, 'App\DTO\CameraDTO[]', 'json');
    }


}
