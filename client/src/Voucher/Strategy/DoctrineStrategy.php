<?php

declare(strict_types=1);

namespace App\Voucher\Strategy;

use App\Contract\VoucherModelInterface;
use App\Entity\CodePromo;
use App\Repository\CodePromoRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This strategy deals with Doctrine to manage the Vouchers.
 */
class DoctrineStrategy implements VoucherStrategyInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    public function findVoucherModel(?string $voucherIdentifier): ?VoucherModelInterface
    {
        if (null === $voucherIdentifier) {
            return null;
        }

        $adaptedVoucher = $this->loadVoucher($voucherIdentifier);

        if (null === $adaptedVoucher) {
            return null;
        }

        return new class ($adaptedVoucher) implements VoucherModelInterface {
            private CodePromo $adaptedObject;

            public function __construct(CodePromo $adaptedObject)
            {
                $this->adaptedObject = $adaptedObject;
            }

            public function getDiscount(): float
            {
                return 0.01 * $this->getRate();
            }

            public function getRate(): float
            {
                return $this->adaptedObject->getPourcentage();
            }
        };
    }

    public function loadVoucher(?string $voucherIdentifier): mixed
    {
        if (null === $voucherIdentifier) {
            return null;
        }

        /** @var CodePromoRepository $voucherRepository */
        $voucherRepository = $this->manager->getRepository(CodePromo::class);

        return $voucherRepository->findOneBy(['code' => $voucherIdentifier]);
    }
}
