<?php

namespace App\EntityListener;

use App\Entity\Cart;
use App\Mail\Notifier;
use App\Event\CameraStockEvent;
use App\Event\VoucherUsedEvent;
use App\Voucher\VoucherInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Voucher\Strategy\VoucherStrategyInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderListener
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private VoucherStrategyInterface $voucherManager,
        private VoucherInterface $defaultVoucher,
        private Notifier $notifier,
        private Security $security,

    ) {
    }

    public function postPersist(Cart $order)
    {
        $eventCamera = new CameraStockEvent($order->getItems());
        $this->eventDispatcher->dispatch($eventCamera, CameraStockEvent::NAME);

        $voucherCode = $this->defaultVoucher->getVoucherIdentifier();
        $voucher = $this->voucherManager->loadVoucher($voucherCode);
        if ($voucher) {
            $eventVoucher = new VoucherUsedEvent($voucher);
            $this->eventDispatcher->dispatch($eventVoucher, VoucherUsedEvent::NAME);
            $this->doCleaning($voucherCode);
        }

        // Notifier
        $this->notifier->orderPlacedNotifier($this->security->getUser()->getEmail());
    }

    private function doCleaning(string $voucherIdentifier): void
    {
        $this->defaultVoucher->invalidateVoucher($voucherIdentifier);
    }
}
