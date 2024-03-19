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
        
>>>>>>> de23d16 (data)
=======
>>>>>>> 8e6fee8 (fix conflit)
=======
        $this->queryString = $queryString;
=======
        $this->prepareQueryCamera = $prepareQueryCamera;
>>>>>>> 85dd608 (maintain catalogue)

>>>>>>> a255480 (fix search)
    }
    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
<<<<<<< HEAD
<<<<<<< HEAD
    }

    public function SearchBy($searchCriteria, $page, $itemsPerPage):array
    {
        $queryString = $this->generateUrl($searchCriteria, $page, $itemsPerPage);
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
            throw new ObjectNotFoundException("Camera not found");
        }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        $cameras = $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
        return $cameras;
=======
        return $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
>>>>>>> 85dd608 (maintain catalogue)
    }
<<<<<<< HEAD

<<<<<<< HEAD
    public function getCameraById(int $id)
=======
    
    public function searchCameras($searchCriteria): String
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
=======
=======
>>>>>>> ce65794 (conflit data)
=======
>>>>>>> ee1b117 (maintain servcie api)
        $cameras = $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
=======
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\DTO\CameraDTO[]', 'json');
        
>>>>>>> 9bb638e (conflit data)
=======
        $cameras = $this->denormalizer->DataDenormalizer($data['hydra:member'],'App\DTO\CameraDTO[]','json');
>>>>>>> 5d2fc98 (maintain servcie api)
        return $cameras;
    }

    public function getCameraById(int $id)
>>>>>>> 8e6fee8 (fix conflit)
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
    
<<<<<<< HEAD
    public function generateUrl($searchCriteria, $page, $itemsPerPage): String
<<<<<<< HEAD
=======
    public function getItems():int
=======
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\Entity\Camera[]', 'json');
=======
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\DTO\CameraDTO[]', 'json');
        
>>>>>>> 2cf0464 (conflit data)
        return $cameras;
    }

    public function getCameraById(int $id)
>>>>>>> de23d16 (data)
    {
        $endpoint = "/api/cameras/" . $id; 
        $response = $this->getData->getDataFromApi($endpoint);
    
        if (!$response) {
            throw new \Exception("Camera not found");
        }
        $camera = $this->serializer->denormalize($response, 'App\Entity\Camera', 'json');
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
=======
   
>>>>>>> a255480 (fix search)
}