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
        try {
            $response = $this->appDefaultApi->request('GET', $endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'timeout' => 30
                ]
            ]);
            $jsonData = $response->getContent();
            if ($response->getStatusCode() == 404) {
                throw new \Exception("Resource not found at {$endpoint}");
            }
            $data = $this->serializer->decode($jsonData, 'json');
            return $data;
        } catch (\Exception $e) {

            error_log($e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
    public function getTotalItems($endpoint)
    {
        $data = $this->getDataFromApi($endpoint);
        $items = $data["hydra:totalItems"];
        return $items;
    }
}
