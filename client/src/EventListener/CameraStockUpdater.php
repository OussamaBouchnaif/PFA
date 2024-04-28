<?php

namespace App\EventListener;

use App\Event\CameraStockEvent;

use Doctrine\ORM\EntityManagerInterface;

class CameraStockUpdater
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function onOrderPlaced(CameraStockEvent $event)
    {
        foreach ($event->getCameras() as $item) {
            $item->getCamera()->decreaseStock($item->getQuantity());
            $this->entityManager->persist($item->getCamera());
        }
        $this->entityManager->flush();
    }
}
