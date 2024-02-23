<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiCameraService 
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getCameraData():array
    {
        $response = $this->client->request('GET', 'http://api/api/cameras');
        return $response->toArray();
    }
}