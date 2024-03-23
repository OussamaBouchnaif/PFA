<?php

namespace App\Service\Api;
use App\Service\Api\Denormalizer;
use Symfony\Component\Serializer\SerializerInterface;
<<<<<<< HEAD
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\Api\Exception\ObjectNotFoundException;
use App\Service\Api\Query\PrepareQueryCamera;
use App\Service\Api\Query\QueryStringBuilder;


class CallApiCameraService 
{
    private $getData;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8e6fee8 (fix conflit)
    private $denormalizer;
    private PrepareQueryCamera $prepareQueryCamera;
    public function __construct(GetDataService $getData ,PrepareQueryCamera $prepareQueryCamera, Denormalizer $denormalizer)
    {
        $this->getData = $getData; 
        $this->denormalizer = $denormalizer;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function __construct(SerializerInterface $serializer,GetDataService $getData)
    {
        $this->serializer = $serializer;
        $this->getData = $getData; 
        $this->denormalizer = $denormalizer;
=======
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

>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
    }
    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
<<<<<<< HEAD
<<<<<<< HEAD
    }

<<<<<<< HEAD
    public function SearchBy($searchCriteria, $page, $itemsPerPage):array
    {
        $queryString = $this->generateUrl($searchCriteria, $page, $itemsPerPage);
=======
    public function SearchBy(array $searchCriteria,int $page,int $itemsPerPage):array
    {
        $queryString = $this->prepareQueryCamera->prepareQueryString($searchCriteria, $page, $itemsPerPage); 
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
        return $this->getCameraData('api/cameras/?' . $queryString);
=======
>>>>>>> 44d6728 (adapt api's pagination)
=======
>>>>>>> 8e6fee8 (fix conflit)
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
<<<<<<< HEAD
            throw new \Exception("Camera not found");
        }
<<<<<<< HEAD
<<<<<<< HEAD
        $cameras = $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
=======
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\DTO\CameraDTO[]', 'json');
        
>>>>>>> 9bb638e (conflit data)
=======
        $cameras = $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
>>>>>>> 5d2fc98 (maintain servcie api)
        return $cameras;
=======
            throw new ObjectNotFoundException("Camera not found");
        }
        return $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
    }

    public function getCameraById(int $id)
>>>>>>> 8e6fee8 (fix conflit)
    {
        $endpoint = "/api/cameras/" . $id; 
        $response = $this->getData->getDataFromApi($endpoint);
    
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!' );
        }
<<<<<<< HEAD
        $camera = $this->denormalizer->DataDenormalizer($response,'App\DTO\CameraDTO','json');
        return $camera;
    }
    
    public function getItems():int
    {      
        $items =$this->getData->getTotalItems("api/cameras/");
        return $items;
    }
    
<<<<<<< HEAD
    public function searchCameras($searchCriteria, $page, $itemsPerPage): String
>>>>>>> 44d6728 (adapt api's pagination)
=======
    public function generateUrl($searchCriteria, $page, $itemsPerPage): String
>>>>>>> ca2bd99 (add sort by price and date)
=======
>>>>>>> 8e6fee8 (fix conflit)
    {
        
        $queryParts = [];
        foreach ($searchCriteria as $key => $value) {
            if($key === 'prix')
            {
                $queryParts[] = 'prix%5Bbetween%5D='.$value; 
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8e6fee8 (fix conflit)
            }
            else if($key === 'order')
            {
                
                $queryParts[] = 'order%5B'.$value.'%5D=asc';
            }
            else if($key !== 'order' && $key !== 'prix' )
<<<<<<< HEAD
=======
            }
<<<<<<< HEAD
            else
>>>>>>> fa04ec1 (maintain search code)
=======
            else if($key === 'order')
            {
                
                $queryParts[] = 'order%5B'.$value.'%5D=asc';
            }
            else if($key !== 'order' && $key !== 'prix' )
>>>>>>> ca2bd99 (add sort by price and date)
=======
>>>>>>> 8e6fee8 (fix conflit)
            {
                $queryParts[] = $key.'='.$value; 
            }
                    
        }
        $queryParts[] = 'page=' . $page;
        $queryParts[] = 'itemsPerPage=' . $itemsPerPage;
<<<<<<< HEAD
=======
            }else
            {
                $queryParts[] = $key.'='.$value; 
            }
                    
        }
<<<<<<< HEAD
        
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
=======
        $queryParts[] = 'page=' . $page;
        $queryParts[] = 'itemsPerPage=' . $itemsPerPage;
>>>>>>> 44d6728 (adapt api's pagination)
=======
>>>>>>> 8e6fee8 (fix conflit)
        $queryString = implode('&', $queryParts);
        return $queryString;
        
    }
}