<?php

namespace App\Reduction\Manager\Strategy;

use App\Entity\Camera;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractReductionStrategy implements ReductionStrategyInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
        
    }

    public  function loadReduction(Camera $camera)
    {
        return $this->manager->getRepository(Camera::class)->findReductionsForCamera($camera->getId());   
    }

    public function supportsType(string $type): bool
    {
        return $this->getType() === $type;
    }
  
}
