<?php



namespace App\Cart\Handler;

use App\Entity\Camera;
use App\Entity\CartItem;


interface CartStorageInterface 
{
    public function addToCart(CartItem $item);
    public function updateCart();
    public function clearCart();
    public function getCart();
}