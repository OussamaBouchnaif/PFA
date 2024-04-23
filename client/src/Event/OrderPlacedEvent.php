<?php

namespace App\Event;

use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\EventDispatcher\Event;

class OrderPlacedEvent extends Event
{
    public const NAME = 'order.placed';

    public function __construct(private Collection $cameras)
    {
    }

    public function getCameras(): Collection
    {
        return $this->cameras;
    }

}
