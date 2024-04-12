<?php

namespace App\Service\Api\Cameras;
use App\Service\Api\Exception\ObjectNotFoundException;


class getAllCameras extends CameraDataService
{

    public function getAllCamera(int $page):array
    {
        return $this->getCameraData('api/cameras?page='.$page);
    }


    public function getCameraById(int $id)
    {
        $endpoint = "/api/cameras/" . $id; 
        $response = $this->getData->getDataFromApi($endpoint);
    
        if (!$response) {
            throw new ObjectNotFoundException('Camera Not Found !!' );
        }
        return $this->denormalizer->DataDenormalizer($response,'App\DTO\CameraDTO','json');
    }
    
    public function getItems():int
    {      
        $items =$this->getData->getTotalItems("api/cameras/");
        return $items;
    }
    
   
}