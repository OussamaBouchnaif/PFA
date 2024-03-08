<?php

namespace App\Service\Api;
use App\Service\Api\Denormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\Api\Exception\ObjectNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\serializer;

class CallApiCameraService 
{
    private $serializer;
    private $getData;
    private $denormalizer;
    public function __construct(SerializerInterface $serializer,GetDataService $getData , Denormalizer $denormalizer)
    {
        $this->serializer = $serializer;
        $this->getData = $getData; 
        $this->denormalizer = $denormalizer;
    }
    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
<<<<<<< HEAD
    }

    public function SearchBy($searchCriteria, $page, $itemsPerPage):array
    {
        $queryString = $this->generateUrl($searchCriteria, $page, $itemsPerPage);
        return $this->getCameraData('api/cameras/?' . $queryString);
=======
>>>>>>> 44d6728 (adapt api's pagination)
    }

    public function SearchBy($searchCriteria, $page, $itemsPerPage):array
    {
        $queryString = $this->generateUrl($searchCriteria, $page, $itemsPerPage);
        return $this->getCameraData('api/cameras/?' . $queryString);
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
<<<<<<< HEAD

<<<<<<< HEAD
    public function getCameraById(int $id)
=======
    
    public function searchCameras($searchCriteria): String
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
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
    
    public function generateUrl($searchCriteria, $page, $itemsPerPage): String
=======
    public function getItems():int
    {
        $response = $this->appDefaultApi->request('GET', 'api/cameras',['headers' => [
            'Content-Type' => 'application/json',
        ]]);
        $jsonData = $response->getContent(); 
        $data = $this->serializer->decode($jsonData,'json');
        $items = $data["hydra:totalItems"];
        return $items;
    }
    
<<<<<<< HEAD
    public function searchCameras($searchCriteria, $page, $itemsPerPage): String
>>>>>>> 44d6728 (adapt api's pagination)
=======
    public function generateUrl($searchCriteria, $page, $itemsPerPage): String
>>>>>>> ca2bd99 (add sort by price and date)
    {
        
        $queryParts = [];
        foreach ($searchCriteria as $key => $value) {
            if($key === 'prix')
            {
                $queryParts[] = 'prix%5Bbetween%5D='.$value; 
<<<<<<< HEAD
<<<<<<< HEAD
            }
            else if($key === 'order')
            {
                
                $queryParts[] = 'order%5B'.$value.'%5D=asc';
            }
            else if($key !== 'order' && $key !== 'prix' )
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
            {
                $queryParts[] = $key.'='.$value; 
            }
                    
        }
        $queryParts[] = 'page=' . $page;
        $queryParts[] = 'itemsPerPage=' . $itemsPerPage;
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
        $queryString = implode('&', $queryParts);
        return $queryString;
        
    }
}