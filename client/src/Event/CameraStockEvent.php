<?php

namespace App\Event;

use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\EventDispatcher\Event;

class CameraStockEvent extends Event
{
    public const NAME = 'camera.stock';

    public function __construct(private Collection $cameras)
    {
    }

    public function getCameras(): Collection
    {
        return $this->cameras;
    }

}
