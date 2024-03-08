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
        $response = $this->appDefaultApi->request('GET', $endpoint,['headers' => [
            'Content-Type' => 'application/json',
        ]]);
        $jsonData = $response->getContent(); 
        $data = $this->serializer->decode($jsonData,'json');
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\Entity\Camera[]', 'json');
        return $cameras;
    }
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