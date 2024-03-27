<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column]
    private ?float $price = null;
    
    #[ORM\ManyToOne(inversedBy: 'cartItems')]
    private ?Camera $Camera = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Cart $cart = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $stockage = null;

    public function __construct(Camera $Camera,float $quantity,string $stockage )
    {
        $this->Camera = $Camera;
        $this->quantity = $quantity;
        $this->stockage = $stockage;
    }
    public function TotalPriceItem():float
    {
       return $this->getQuantity() * $this->getPrice();

    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    } 
    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCamera(): ?Camera
    {
        return $this->Camera;
    }

    public function setCamera(?Camera $Camera): static
    {
        $this->Camera = $Camera;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): static
    {
        $this->cart = $cart;

        return $this;
    }

    public function getStockage(): ?string
    {
        return $this->stockage;
    }

    public function setStockage(?string $stockage): static
    {
        $this->stockage = $stockage;

        return $this;
    }
}
