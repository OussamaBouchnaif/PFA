<?php

declare(strict_types=1);

namespace App\Processor;

use App\Cart\Handler\CartStorageInterface;
use App\Cart\Persister\CartPersisterInterface;
use App\Discount\DiscountLoader;
use App\Entity\Cart;
use App\Voucher\Strategy\VoucherStrategyInterface;
use App\Voucher\VoucherInterface;

final class CartProcessor
{
    public function __construct(
        private readonly DiscountLoader $discountLoader,
        private readonly VoucherStrategyInterface $strategy,
        private readonly VoucherInterface $voucherManager,
        private readonly CartStorageInterface $cartStorage,
        private readonly CartPersisterInterface $cartPersister,
    ) {
    }

    /**
     * Processes the cart.
     */
    public function process(Cart $instance, ?string $voucherIdentifier): void
    {
        if (null !== $voucherIdentifier) {
            $this->discountLoader->loadDiscount($instance, $voucherIdentifier, $this->strategy);
            $instance = $this->doUpdateTotal($instance, $voucherIdentifier);
            $this->doCleaning($voucherIdentifier);
        } else {
            $instance->setTotal($instance->computeTotal());
        }

        $this->cartPersister->persist($instance);
    }

    /**
     * Recomputes the totals based on the strategy used.
     */
    private function doUpdateTotal(Cart $cart, string $voucherIdentifier): Cart
    {
        $voucherModel = $this->strategy->findVoucherModel($voucherIdentifier);

        $discountedCart = $this->voucherManager->getDiscountedCart($cart, $voucherModel);

        $cart->setTotal($discountedCart->getTotal());

        return $cart;
    }

    /**
     * Internally clears the cart from the storage and invalidates the voucher.
     */
    private function doCleaning(string $voucherIdentifier): void
    {
        $this->cartStorage->clearCart($this->cartStorage->getCart());
        $this->voucherManager->invalidateVoucher($voucherIdentifier);
    }
}
