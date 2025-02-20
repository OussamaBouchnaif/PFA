<?php

namespace App\ValueObject;

use App\Entity\Client;
use App\ValueObject\CartItemValueObject;

final class CartValueObject
{
    private array $items;
    private ?Client $user=null;

    public function __construct(array $items = [])
    {
        $this->items = $items;

    }

    /**
     * Get the value of items
     */ 
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the value of items
     *
     * @return  self
     */ 
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser(?Client $user = null)
    {
        $this->user = $user;

        return $this;
    }

    public function add(CartItemValueObject $object)
    {
        if(($index=$this->findItem($object)) !== null)
        {
            $object = $this->updateCartItem($object,$this->items[$index],$index);
        }
        $this->items[$object->getId()] = $object;
        
    }
    public function remove(CartItemValueObject $object)
    {
        if(($index=$this->findItem($object)) !== null) {
            unset($this->items[$index]);
        }
    }

    public function getLines()
    {
        return $this->items;
    }

    public function getCount()
    {
        return count($this->getLines());
    }

    public function findItem(CartItemValueObject $object)
    {
        if (array_key_exists($object->getId(), $this->items)) {
            return $object->getId();
        }
        
       return null;
    }

    public function updateCartItem(CartItemValueObject $requestedCartItem,CartItemValueObject $exsistingCartItem,?int $index)
    {
        if(null === $index)
        {
            return $requestedCartItem;
        }

        $item = new CartItemValueObject($index,
            $exsistingCartItem->getImage(),
            $requestedCartItem->getQuantity()+$exsistingCartItem->getQuantity(),
            $exsistingCartItem->getStockage(),
            $exsistingCartItem->getName());
        $item->setPrice($exsistingCartItem->getPrice());
        
        return $item;
    }

    
    public function clear()
    {
        return $this->setItems([]);
    }
}
