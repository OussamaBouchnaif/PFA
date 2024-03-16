<?php

namespace App\Service\Api;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetDataService 
{
    private $appDefaultApi;
    private $serializer;
    
    public function __construct(HttpClientInterface $appDefaultApi,SerializerInterface $serializer)
    {
        $this->appDefaultApi = $appDefaultApi;
        $this->serializer = $serializer;
        
    }
    public function getDataFromApi(String $endpoint):array
    {
        $response = $this->appDefaultApi->request('GET', $endpoint,['headers' => [
            'Content-Type' => 'application/json',
        ]]);
        $jsonData = $response->getContent(); 
        $data = $this->serializer->decode($jsonData,'json');
        return $data;
    }
    public function getTotalItems($endpoint)
    {
        $data =$this->getDataFromApi($endpoint);
        $items = $data["hydra:totalItems"];
        return $items;
    }
}
