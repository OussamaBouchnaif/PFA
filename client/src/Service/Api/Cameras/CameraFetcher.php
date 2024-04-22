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

        $queryString = $this->prepareQueryString($searchCriteria);
        return $this->getCameraData('api/cameras/?' . $queryString);
    }


    private function prepareQueryString(array $searchCriteria): String
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
