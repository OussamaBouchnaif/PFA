<?php

namespace App\Service\Api;
use App\Service\Api\Denormalizer;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use App\Service\Api\Query\PrepareQueryCamera;
use App\Service\Api\Exception\ObjectNotFoundException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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

    public function SearchBy(array $searchCriteria):array
    {
        $queryString = $this->prepareQueryCamera->prepareQueryString($searchCriteria); 
        return $this->getCameraData('api/cameras/?' . $queryString);
    }
    
    public function getCameraData(String $endpoint):array
    {
        $cacheKey = md5($endpoint);
        $cache = new FilesystemAdapter();

        $data = $cache->get($cacheKey, function (ItemInterface $item) use ($endpoint) {
            $item->expiresAfter(3600);
            $data = $this->getData->getDataFromApi($endpoint);
            if (!$data) {
                throw new ObjectNotFoundException("Camera not found");
            }
            return $data;
        });

        return $this->denormalizer->DataDenormalizer($data['hydra:member'], 'App\DTO\CameraDTO[]', 'json');
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