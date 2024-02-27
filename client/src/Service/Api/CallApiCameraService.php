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
    public function getCameraData():array
    {
        $response = $this->appDefaultApi->request('GET', '/api/cameras',['headers' => [
            'Content-Type' => 'application/json',
        ]]);
        $jsonData = $response->getContent(); 
        $data = $this->serializer->decode($jsonData,'json');
        $cameras = $this->serializer->denormalize($data['hydra:member'], 'App\Entity\Camera[]', 'json');
        return $cameras;
    }
}