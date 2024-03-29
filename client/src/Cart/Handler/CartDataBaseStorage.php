<?php

namespace App\Cart\Handler;

use App\Entity\Cart;
use App\Entity\CartItem;

class CartDataBaseStorage implements CartStorageInterface
{
    public function addToCart(CartItem $item){

    }

    public function removeFromCart(Cart $cart,int $idItem)
    {

    }
    public function clearCart(){

    }
    public function getCart(){
        
    }
    public function TotalPriceItems():float
    {
        return 0.0;
    }
}