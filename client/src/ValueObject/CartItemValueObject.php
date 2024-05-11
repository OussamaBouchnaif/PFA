<?php

namespace App\ValueObject;

use Doctrine\Common\Collections\Collection;

final class CartItemValueObject
{
    private float $price;
    public function __construct(
        private int $id,
        private Collection $image,
        private int $quantity,
        private float $stockage,
        private string $name)
    {}
 
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get the value of stockage
     */ 
    public function getStockage()
    {
        return $this->stockage;
    }

  

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

   

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }


    

    public function TotalPriceItem():float
    {
       return $this->getQuantity() * $this->getPrice();

    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
            $this->id = $id;

            return $this;
    }

        /**
         * Set the value of stockage
         *
         * @return  self
         */ 
        public function setStockage($stockage)
        {
                $this->stockage = $stockage;

                return $this;
        }
}
