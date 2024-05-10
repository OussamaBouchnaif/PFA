<?php



namespace App\Cart\Handler;

use App\Entity\Camera;
use App\ValueObject\CartValueObject;

interface CartStorageInterface 
{
    public function addToCart(Camera $camera,int $qte,float $stockage);
    public function removeFromCart(int $idItem);
    public function clearCart(CartValueObject $cart);
    public function getCart():CartValueObject;
    public function TotalPriceItems():float;
    public function updateLine(int $id,int $qte);
}