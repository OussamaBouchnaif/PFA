<?php


namespace App\Cart\Handler;

use App\Entity\Camera;
use App\ValueObject\CartValueObject;
use App\ValueObject\CartItemValueObject;
use App\Cart\Handler\AbstractCartStorage;
use Symfony\Bundle\SecurityBundle\Security;
use App\Reduction\Applier\AbstractDiscountApplier;
use Symfony\Component\HttpFoundation\RequestStack;


class CartSessionStorage extends AbstractCartStorage
{
    private $cartSessionKey = 'cart';

    public function __construct(
        private readonly RequestStack $request,
        private Security $security,
        AbstractDiscountApplier $applier
    ) {
        parent::__construct($applier);
    }

    public function addToCart(Camera $camera, int $qte, float $stockage)
    {
        $cart = $this->getCart();
        $item = new CartItemValueObject(
            $camera->getId(),
            $camera->getImageCameras(),
            $qte,
            $stockage,
            $camera->getNom()
        );
        $this->applier->applyDiscount($item);
        $cart->add($item);
        $this->saveCart($cart);
    }

    /**
     * Retrieves or initializes cart.
     *
     * @return CartValueObject 
     */

    public function getCart(): CartValueObject
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

    /**
     * Calculate the total price of all items in the cart.
     *
     * @return float The total price of all items.
     */
    public function TotalPriceItems(): float
    {
        $totalPrice = 0.0;
        $cart = $this->getCart();
        $items = $cart->getItems();
        foreach ($items as $item) {
            $totalPrice += $item->getPrice() * $item->getQuantity();
        }

        return $totalPrice;
    }

    /**
     * remove line from cart 
     *
     * @return void .
     */
    public function removeFromCart(int $idItem)
    {
        $cart = $this->getCart();
        $items = $cart->getItems();
        if (array_key_exists($idItem, $items)) {
            $cartItem = $items[$idItem];
            $cart->remove($cartItem);
            $this->saveCart($cart);
        }
    }

    /**
     * update line from cart 
     *
     * @return void .
     */
    public function updateLine(int $id, int $qte)
    {
        $cart = $this->getCart();
        $items = $cart->getItems();
        if (array_key_exists($id, $items)) {
            $cartItem = $items[$id];
            $cartItem->setQuantity($qte);
            $this->saveCart($cart);
        }
    }

    /**
         * get number of items 
         *
         * @return int .
     */
    public function getCartCount():int
    {
        return $this->getCart()->getCount();
    }
    /**
     * clear cart 
     *
     * @return void .
     */
    public function clearCart(CartValueObject $cart)
    {
        $cart->clear();
    }

    private function saveCart(CartValueObject $cart): void
    {
        $session = $this->request->getSession();
        $session->set($this->cartSessionKey, $cart);
    }
}
