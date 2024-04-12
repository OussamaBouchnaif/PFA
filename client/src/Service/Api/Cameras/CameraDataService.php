<?php

namespace App\Service\Api\Cameras;


use App\Service\Api\GetDataService;
use Symfony\Contracts\Cache\ItemInterface;
use App\Service\Api\Query\PrepareQueryCamera;
use App\Service\Api\Denormalizer\Denormalizer;
use App\Service\Api\Exception\ObjectNotFoundException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


abstract class CameraDataService
{
    public function __construct(
        protected GetDataService $getData,
        protected PrepareQueryCamera $prepareQueryCamera,
        protected Denormalizer $denormalizer,

    ) {}

    public function getCameraData(String $endpoint):array
    {
        $cacheKey = md5($endpoint);
        $cache = new FilesystemAdapter();

        $data = $cache->get($cacheKey, function (ItemInterface $item) use ($endpoint) {
            $item->expiresAfter(3600);
            $data = $this->getData->getDataFromApi($endpoint);
            if (!$data) {
                throw new ObjectNotFoundException("Camera not found");
            }
            return $data;
        });

        return $this->denormalizer->dataDenormalizer($data['hydra:member'], 'App\DTO\CameraDTO[]', 'json');
    }
}
