<?php

namespace App\Service\Api;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\serializer;

class CallApiCameraService 
{
    private $appDefaultApi;
    private $serializer;
    
    public function __construct(HttpClientInterface $appDefaultApi,SerializerInterface $serializer)
    {
        $this->appDefaultApi = $appDefaultApi;
        $this->serializer = $serializer;
        
    }
    public function getAllCamera():array
    {
        return $this->getCameraData('api/cameras');
    }

    public function SearchBy($searchCriteria):array
    {
        $queryString = $this->searchCameras($searchCriteria);
        return $this->getCameraData('api/cameras/?' . $queryString);
    }
    
    public function getCameraData(String $endpoint):array
    {
        $response = $this->appDefaultApi->request('GET', $endpoint,['headers' => [
            'Content-Type' => 'application/json',
        ]]);
        $jsonData = $response->getContent(); 
        $data = $this->serializer->decode($jsonData,'json');
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\Entity\Camera[]', 'json');
        return $cameras;
    }

    
    public function searchCameras($searchCriteria): String
    {

        $queryParts = [];
        foreach ($searchCriteria as $key => $value) {
            if($key === 'prix')
            {
                $queryParts[] = 'prix%5Bbetween%5D='.$value; 
            }else
            {
                $queryParts[] = $key.'='.$value; 
            }
                    
        }
        
        $queryString = implode('&', $queryParts);
        return $queryString;
        
    }
}