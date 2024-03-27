<?php


namespace App\Cart\Persister;

use App\Entity\Cart;


interface CartPersisterInterface 
{
    public function persist(Cart $cart): void;
}
