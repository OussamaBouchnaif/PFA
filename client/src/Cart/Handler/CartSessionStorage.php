<?php


namespace App\Cart\Handler;

use App\Calculator\CalculatorContext;
use App\Entity\Cart;
use App\Entity\Camera;
use App\ValueObject\CartValueObject;
use App\ValueObject\CartItemValueObject;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;


class CartSessionStorage implements CartStorageInterface
{
    private $cartSessionKey = 'cart';

    public function __construct(private readonly RequestStack $request,
    private CalculatorContext $calculator,
    private Security $security)
    {

    }
    
    public function addToCart(Camera $camera,int $qte,float $stockage)
    {
        $cart = $this->getCart(); 
        $cart->addToCart(new CartItemValueObject($camera->getId(),$camera->getImageCameras(),$camera->getPrix(),$qte,$stockage));
        $this->saveCart($cart);
    }
   
    public function getCart():CartValueObject
    {
        $session = $this->request->getSession();
        $cart = $session->get($this->cartSessionKey);

        if (!$cart) {
            $cart = new CartValueObject();
            $cart->setUser($this->security->getUser());
            $session->set($this->cartSessionKey, $cart);
        }

        return $cart;
    }
    
    public function TotalPriceItems():float
    {
        return $this->calculator->priceCalculator($this->getCart());
    }
    public function removeFromCart(int $idItem)
    {
        $cart = $this->getCart(); // Récupère le panier actuel
    // Récupère les lignes du panier
        $items = $cart->getItems();
        // Vérifie si l'article existe dans le panier et le supprime
        if (array_key_exists($idItem, $items)) {
            $cartItem = $items[$idItem];
            $cart->removeFromCart($cartItem);
            $this->saveCart($cart); // Sauvegarde les modifications dans la session
        }
    }
   

    public function clearCart(CartValueObject $cart){
        $cart->clear();
    }

    private function saveCart(CartValueObject $cart): void
    {
        $session = $this->request->getSession();
        $session->set($this->cartSessionKey, $cart);
    }

}