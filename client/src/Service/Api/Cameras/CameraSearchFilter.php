<?php

namespace App\Service\Api\Cameras;


class CameraSearchFilter extends CameraDataService
{

    public function searchBy(array $searchCriteria): array
    {
        $queryString = $this->prepareQueryCamera->prepareQueryString($searchCriteria);
        return $this->getCameraData('api/cameras/?' . $queryString);
    }

}
