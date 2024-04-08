<?php



namespace App\Cart\Handler;

use App\Entity\Cart;
use App\Entity\Camera;
use App\Entity\CartItem;
use App\ValueObject\CartValueObject;

interface CartStorageInterface 
{
    public function addToCart(Camera $camera,int $qte,float $stockage);
    public function removeFromCart(CartValueObject $cart,int $idItem);
    public function clearCart(CartValueObject $cart);
    public function getCart():CartValueObject;
    public function TotalPriceItems():float;
}