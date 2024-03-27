<?php

namespace App\Cart\Persister;

use App\Entity\Cart;
use App\Cart\Persister\CartPersisterInterface;



class CartDatabasePersister implements  CartPersisterInterface
{
    public function persist(Cart $cart):void
    {
        
    }   
}