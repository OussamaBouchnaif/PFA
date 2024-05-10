<?php

namespace App\Service\Api\Cameras;


use App\Service\Api\GetDataService;
use Symfony\Contracts\Cache\ItemInterface;
use App\Service\Api\Query\QueryStringBuilder;
use App\Service\Api\Denormalizer\Denormalizer;
use App\Service\Api\Cameras\CameraFetcherInterface;
use App\Service\Api\Exception\ObjectNotFoundException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


abstract class AbstractCameraFetcher implements CameraFetcherInterface
{
    private FilesystemAdapter $cache ;
    public function __construct(
        protected GetDataService $getData,
        protected QueryStringBuilder $queryStringBuilder,
        protected Denormalizer $denormalizer,
        

    ) {

        $this->cache = new FilesystemAdapter();
    }

    public function getCameraData(String $endpoint):array
    {
        
        $cacheKey = md5($endpoint);
        

        $data = $this->cache->get($cacheKey, function (ItemInterface $item) use ($endpoint) {
            $item->expiresAfter(3600);
            $data = $this->getData->getDataFromApi($endpoint);
            if (!$data) {
                throw new ObjectNotFoundException("Camera not found");
            }
            return $data;
        });

        return $this->denormalizer->dataDenormalizer($data['hydra:member'], 'App\DTO\CameraDTO[]', 'json');
    }

    public function clearCache()
    {
        $this->cache->clear();
    }
}
