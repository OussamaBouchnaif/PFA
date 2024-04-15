<?php

namespace App\Service\Api\Cameras;

use App\Service\Api\Cameras\AbstractCameraFetcher;
use App\Service\Api\Exception\ObjectNotFoundException;

class CameraFetcher extends AbstractCameraFetcher
{
    public function getAllCamera(int $page): array
    {
        return $this->getCameraData('api/cameras?page=' . $page);
    }

    public function getCameraById(int $id)
    {
        $endpoint = "/api/cameras/" . $id;
        $response = $this->getData->getDataFromApi($endpoint);

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

    public function searchBy(array $searchCriteria): array
    {
        
        $queryString = $this->prepareQueryString($searchCriteria);
        return $this->getCameraData('api/cameras/?' . $queryString);
    }


    public function prepareQueryString(array $searchCriteria): String
    {
        $queryStringBuilder = $this->queryStringBuilder;

        foreach ($searchCriteria as $key => $value) {
            if (!is_null($value)) {
                switch ($key) {
                    case 'categorie.nom':
                        $queryStringBuilder = $queryStringBuilder->addCategorieNameParameter($value);
                        break;
                    case 'order':
                        $queryStringBuilder = $queryStringBuilder->addOrder($value);
                        break;
                    case 'resolution':
                        $queryStringBuilder = $queryStringBuilder->addResolution($value);
                        break;
                    case 'angleVision':
                        $queryStringBuilder = $queryStringBuilder->addAngleVision($value);
                        break;
                    case 'prix':
                        $queryStringBuilder = $queryStringBuilder->addPriceRangeParameter($value);
                        break;
                }
            }
        }
        return $queryStringBuilder->getQueryString();
    }
}
