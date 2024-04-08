<?php

namespace App\ValueObject;

use Doctrine\Common\Collections\Collection;

final class CartItemValueObject
{
    public function __construct(private int $id,private Collection $image,
    private float $price,
    private float $quantity,
    private float $stockage)
    {
        
    }
    public function TotalPriceItem():float
    {
       return $this->getQuantity() * $this->getPrice();

    }
    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }



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
}
