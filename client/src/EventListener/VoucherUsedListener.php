<?php

namespace App\EventListener;

use App\Event\VoucherUsedEvent;
use App\Voucher\Strategy\VoucherStrategyInterface;
use App\Voucher\VoucherInterface;
use Doctrine\ORM\EntityManagerInterface;

class VoucherUsedListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,

    )
    {
    }

    public function onVoucherUsed(VoucherUsedEvent $event)
    {
        
        $voucher = $event->getPromoCode();
        if ($voucher->getNombreAutorisation() > 0) {
            $voucher->setNombreAutorisation($voucher->getNombreAutorisation() - 1);
            $this->entityManager->flush();
        }
    }
}
