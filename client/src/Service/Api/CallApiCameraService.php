<?php

namespace App\Service\Api;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
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
    public function getCameraByCategorie(String $categorie):array
    {
        return $this->getCameraData('api/cameras/?categorie.nom='.$categorie);
    }
    public function getCameraByPrix(int $prix1 , int $prix2)
    {
        return $this->getCameraData('api/cameras/?prix%5Bbetween%5D='.$prix1.'..'.$prix2);
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
}