<?php

namespace App\Service\Api;
use App\Service\Api\Denormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Api\Exception\ObjectNotFoundException;
use App\Service\Api\Query\PrepareQueryCamera;
use App\Service\Api\Query\QueryStringBuilder;


class CallApiCameraService 
{
    private $getData;
    private $denormalizer;
    private PrepareQueryCamera $prepareQueryCamera;
    public function __construct(GetDataService $getData ,PrepareQueryCamera $prepareQueryCamera, Denormalizer $denormalizer)
    {
        $this->getData = $getData; 
        $this->denormalizer = $denormalizer;
        $this->prepareQueryCamera = $prepareQueryCamera;

    }
    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
    }

    public function SearchBy(array $searchCriteria,int $page,int $itemsPerPage):array
    {
        $queryString = $this->prepareQueryCamera->prepareQueryString($searchCriteria, $page, $itemsPerPage); 
        return $this->getCameraData('api/cameras/?' . $queryString);
    }
    
    public function getCameraData(String $endpoint):array
    {
        $data = $this->getData->getDataFromApi($endpoint);
        if (!$data) {
            throw new ObjectNotFoundException("Camera not found");
        }
        return $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
    }

    public function getCameraById(int $id)
    {
        $endpoint = "/api/cameras/" . $id; 
        $response = $this->getData->getDataFromApi($endpoint);
    
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!' );
        }
        return $this->denormalizer->DataDenormalizer($response,'App\DTO\CameraDTO','json');
    }
    
    public function getItems():int
    {      
        $items =$this->getData->getTotalItems("api/cameras/");
        return $items;
    }
    
   
}