<?php

namespace App\Service\Api\Denormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class Denormalizer 
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function dataDenormalizer($data,$entity,$format)
    {
        return $this->serializer->denormalize($data, $entity, $format);
    }
}