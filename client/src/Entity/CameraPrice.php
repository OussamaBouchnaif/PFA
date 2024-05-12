<?php

namespace App\Entity;

class CameraPrice
{
    public function __construct(
        private float $originalPrice,
        private  float $discountedPrice,
        private float $discountValue,
        private float $discountRate
    ) {
    }

    /**
     * Get the value of originalPrice
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * Set the value of originalPrice
     *
     * @return  self
     */
    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = $originalPrice;

        return $this;
    }

    /**
     * Get the value of discountedPrice
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * Set the value of discountedPrice
     *
     * @return  self
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }

    /**
     * Get the value of discountValue
     */
    public function getDiscountValue()
    {
        return $this->discountValue;
    }

    /**
     * Set the value of discountValue
     *
     * @return  self
     */
    public function setDiscountValue($discountValue)
    {
        $this->discountValue = $discountValue;

        return $this;
    }

    /**
     * Get the value of discountRate
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * Set the value of discountRate
     *
     * @return  self
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;

        return $this;
    }
}
