<?php

namespace App\Event;

use App\Entity\CodePromo;

class VoucherUsedEvent
{
    public const NAME = 'voucher.used';

    protected $promoCode;

    public function __construct(?CodePromo $promoCode)
    {
        $this->promoCode = $promoCode;
    }

    public function getPromoCode(): CodePromo
    {
        return $this->promoCode;
    }


}
