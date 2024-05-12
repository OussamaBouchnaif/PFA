<?php

declare(strict_types=1);

namespace App\Voucher;

use App\Contract\DiscountedCartInterface;
use App\Contract\DiscountedObjectInterface;
use App\Contract\DiscountModelInterface;
use App\Entity\Cart;
use App\Voucher\Strategy\VoucherStrategyInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * This voucher manager handles the vouchers via Doctrine.
 */
class DefaultVoucher implements VoucherInterface
{
    public function __construct(
        private readonly RequestStack $stack,
        private readonly VoucherStrategyInterface $strategy,
    ) {
    }

    public function applyVoucher(string $voucherCode, Cart $object): DiscountedObjectInterface
    {
        if (false === $this->isAlreadyApplied($voucherCode, $object)) {
            // if the voucher is already applied to the current cart, no need to re-apply it again.
            $this->placeNewVoucher($voucherCode);
        }

        $voucherInstance = $this->strategy->findVoucherModel($voucherCode);
        
        return $this->getDiscountedCart($object, $voucherInstance);
    }

    public function isAlreadyApplied(?string $voucherCode, Cart $cart): bool
    {
        if (null === $voucherCode) {
            return false;
        }

        $session = $this->stack->getSession();

        return $session->has('voucher_code');
    }

    public function getVoucherIdentifier(): ?string
    {
        $session = $this->stack->getSession();

        return $session->has('voucher_code') ? $session->get('voucher_code') : null;
    }

    public function placeNewVoucher(string $voucherIdentifier): bool
    {
        // if the voucher is already applied to the current cart, no need to re-apply it again.
        $session = $this->stack->getSession();
        $session->set('voucher_code', $voucherIdentifier);

        return true;
    }

    public function getDiscountedCart(Cart $object, ?DiscountModelInterface $voucherInstance): DiscountedObjectInterface
    {
        return new class($object, $voucherInstance) implements DiscountedObjectInterface {
            private Cart $object;
            private ?DiscountModelInterface $voucherInstance;

            public function __construct(Cart $object, ?DiscountModelInterface $voucherInstance)
            {
                $this->object = $object;
                $this->voucherInstance = $voucherInstance;
            }

            public function getTotal(): float
            {
                $total = $this->object->computeTotal();

                if (null === $this->voucherInstance) {
                    return $total;
                }

                return $total * (1 - $this->voucherInstance->getDiscount());
            }

            public function getDiscountValue(): float
            {
                if (null === $this->voucherInstance) {
                    return 0.0; 
                }
                return $this->object->computeTotal() * $this->voucherInstance->getDiscount();
            }

            public function getDiscountRate(): float
            {
                if (null === $this->voucherInstance) {
                    return 0.0; 
                }
                return $this->voucherInstance->getRate() ;
            }

            public function getDiscountedType(): string
            {
                return $this->voucherInstance->getType();
            }
        };
    }

    public function invalidateVoucher(?string $voucherIdentifier): bool
    {
        if (null === $voucherIdentifier) {
            return false;
        }

        $session = $this->stack->getSession();
        $session->remove('voucher_code');

        return true;
    }
}
