<?php

namespace App\Service\Api;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetDataService
{
    public function __construct(private HttpClientInterface $appDefaultApi, private  SerializerInterface $serializer)
    {
    }
    public function getDataFromApi(String $endpoint): array
    {
        $response = $this->appDefaultApi->request('GET', $endpoint, ['headers' => [
            'Content-Type' => 'application/json',
        ]]);
        $jsonData = $response->getContent();
        $data = $this->serializer->decode($jsonData, 'json');
        return $data;
    }
    public function getTotalItems($endpoint)
    {
        $data = $this->getDataFromApi($endpoint);
        $items = $data["hydra:totalItems"];
        return $items;
    }
}
