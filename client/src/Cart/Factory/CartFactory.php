<?php

namespace App\Cart\Factory;

use App\Entity\Cart;
use App\Entity\Camera;
use App\Entity\CartItem;
use App\ValueObject\CartValueObject;
use Doctrine\ORM\EntityManagerInterface;
use App\Cart\Denormalizer\AbstractCartNormalizer;
use App\Enum\CartStatus;
use Symfony\Bundle\SecurityBundle\Security;

final class CartFactory
{
    public function __construct(
        private Security $security,
        private AbstractCartNormalizer $normaliser,
        private EntityManagerInterface $manager
    ) {
    }

    public function build(): Cart
    {
        $cart = new Cart();
        $cartInfo = $this->normaliser->getCart();
        $cart->setStatus(CartStatus::placed)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdateAt(new \DateTimeImmutable())
            ->setClient($this->security->getUser());


        $this->load($cart, $cartInfo);
        return $cart;
    }

    private function load(Cart $cart, CartValueObject $cartValueObject): void
    {
        $lines = $cartValueObject->getLines();

        $cameras = $this->manager->getRepository(Camera::class)->findBy(['id' => array_keys($lines)]);

        foreach ($cameras as $item) {
            $cartItem = new CartItem();
            $cartItem->setCart($cart)
                ->setCamera($item)
                ->setQuantity($lines[$item->getId()]->getQuantity())
                ->setPrice($lines[$item->getId()]->getPrice())
                ->setStockage($lines[$item->getId()]->getStockage());
            $cart->addItem($cartItem);
        }
    }
}
