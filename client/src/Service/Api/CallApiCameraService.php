<?php

namespace App\Service\Api;
use App\Service\Api\Denormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Api\Exception\ObjectNotFoundException;
use App\Service\Api\Query\QueryStringBuilder;


class CallApiCameraService 
{
    private $getData;
    private $denormalizer;
    private $queryString;
    public function __construct(GetDataService $getData ,QueryStringBuilder $queryString, Denormalizer $denormalizer)
    {
        $this->getData = $getData; 
        $this->denormalizer = $denormalizer;
        $this->queryString = $queryString;

    }
    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
    }

    public function SearchBy(array $searchCriteria,int $page,int $itemsPerPage):array
    {

        $url = $this->queryString->addCategorieNameParameter($searchCriteria['categorie.nom'])
                                 ->addOrder($searchCriteria['order'])
                                 ->setPage($page)
                                 ->setLimitPerPage($itemsPerPage)
                                 ->getQueryString();
        
        return $this->getCameraData('api/cameras/?' . $url);
    }
    
    public function getCameraData(String $endpoint):array
    {
        $data = $this->getData->getDataFromApi($endpoint);
        if (!$data) {
            throw new \Exception("Camera not found");
        }
        $cameras = $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
        return $cameras;
    }

    public function getCameraById(int $id)
    {
        $endpoint = "/api/cameras/" . $id; 
        $response = $this->getData->getDataFromApi($endpoint);
    
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!' );
        }
        $camera = $this->denormalizer->DataDenormalizer($response,'App\DTO\CameraDTO','json');
        return $camera;
    }
    
    public function getItems():int
    {      
        $items =$this->getData->getTotalItems("api/cameras/");
        return $items;
    }
    
   
}