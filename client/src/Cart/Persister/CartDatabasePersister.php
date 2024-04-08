<?php

namespace App\Cart\Persister;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use App\Cart\Persister\CartPersisterInterface;

class CartDatabasePersister implements CartPersisterInterface
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function persist(Cart $cart): void
    {
        foreach ($cart->getItems() as $cartItem) {
            $this->manager->persist($cartItem);
        }
        $this->manager->persist($cart);
        $this->manager->flush();
    }
}
