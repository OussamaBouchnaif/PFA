<?php

namespace App\EventListener;

use App\Event\OrderPlacedEvent;
use App\Mail\Notifier;
use Doctrine\ORM\EntityManagerInterface;

class CameraStockUpdater
{
    public function __construct(private EntityManagerInterface $entityManager,private Notifier $notifier)
    {
    }

    public function onOrderPlaced(OrderPlacedEvent $event)
    {
        foreach ($event->getCameras() as $item) {
            $item->getCamera()->decreaseStock($item->getQuantity());
            $this->entityManager->persist($item->getCamera());
        }
        $this->entityManager->flush();
    }
}
