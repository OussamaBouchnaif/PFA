<?php

namespace App\Voucher;

use App\Entity\Cart;
use App\Contract\DiscountedObjectInterface;
use App\Contract\DiscountModelInterface;

interface VoucherInterface
{
    /**
     * Creates a new voucher and stores it in a storage.
     * Return a boolean indicating the state of the voucher storing: true if everything went well, false otherwise.
     */
    public function placeNewVoucher(string $voucherIdentifier): bool;

    /**
     * Applies the voucher code to the Cart instance.
     */
    public function applyVoucher(string $voucherCode, Cart $object): DiscountedObjectInterface;

    /**
     * Checks if the current voucher code is already applied to the current Cart instance.
     */
    public function isAlreadyApplied(?string $voucherCode, Cart $cart): bool;

    /**
     * Gets the voucher identifier. If none, returns null.
     */
    public function getVoucherIdentifier(): ?string;

    /**
     * Get the discounted cart instance based on a cart instance and a voucher model instance.
     */
    public function getDiscountedCart(Cart $object, ?DiscountModelInterface $voucherInstance): DiscountedObjectInterface;

    /**
     * Invalidates the voucher. Returns true when everything went well, false otherwise.
     */
    public function invalidateVoucher(?string $voucherIdentifier): bool;
}
