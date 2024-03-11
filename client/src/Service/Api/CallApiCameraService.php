<?php

namespace App\Service\Api;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\serializer;

class CallApiCameraService 
{
    private $serializer;
    private $getData;
    public function __construct(SerializerInterface $serializer,GetDataService $getData)
    {
        $this->serializer = $serializer;
        $this->getData = $getData; 
        
    }
    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
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
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\Entity\Camera[]', 'json');
        return $cameras;
    }

    public function getCameraById(int $id)
    {
        $endpoint = "/api/cameras/" . $id; // Ajustez selon l'URL de base de l'API
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
    
    public function generateUrl($searchCriteria, $page, $itemsPerPage): String
    {
        
        $queryParts = [];
        foreach ($searchCriteria as $key => $value) {
            if($key === 'prix')
            {
                $queryParts[] = 'prix%5Bbetween%5D='.$value; 
            }
            else if($key === 'order')
            {
                
                $queryParts[] = 'order%5B'.$value.'%5D=asc';
            }
            else if($key !== 'order' && $key !== 'prix' )
            {
                $queryParts[] = $key.'='.$value; 
            }
                    
        }
        $queryParts[] = 'page=' . $page;
        $queryParts[] = 'itemsPerPage=' . $itemsPerPage;
        $queryString = implode('&', $queryParts);
        return $queryString;
        
    }
}