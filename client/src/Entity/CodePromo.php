<?php

namespace App\Entity;

use App\Repository\CodePromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodePromoRepository::class)]
class CodePromo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $code = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $pourcentage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nombreAutorisation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;


    #[ORM\OneToMany(mappedBy: 'codePromo', targetEntity: Cart::class)]
    private Collection $Cart;

    public function __construct()
    {
        $this->Cart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getNombreAutorisation(): ?int
    {
        return $this->nombreAutorisation;
    }

    public function setNombreAutorisation(int $nombreAutorisation): static
    {
        $this->nombreAutorisation = $nombreAutorisation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

   

    /**
     * @return Collection<int, Cart>
     */
    public function getCart(): Collection
    {
        return $this->Cart;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->Cart->contains($cart)) {
            $this->Cart->add($cart);
            $cart->setCodePromo($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->Cart->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getCodePromo() === $this) {
                $cart->setCodePromo(null);
            }
        }

        return $this;
    }
}
