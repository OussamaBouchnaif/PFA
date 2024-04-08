<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateExpedition = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEstime = null;

    #[ORM\Column(length: 100)]
    private ?string $statusLiv = null;

    #[ORM\Column(length: 100)]
    private ?string $infoSuivi = null;

    #[ORM\Column(length: 100)]
    private ?string $modeLivraison = null;

   

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Cart $Cart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateExpedition(): ?\DateTimeInterface
    {
        return $this->dateExpedition;
    }

    public function setDateExpedition(\DateTimeInterface $dateExpedition): static
    {
        $this->dateExpedition = $dateExpedition;

        return $this;
    }

    public function getDateEstime(): ?\DateTimeInterface
    {
        return $this->dateEstime;
    }

    public function setDateEstime(\DateTimeInterface $dateEstime): static
    {
        $this->dateEstime = $dateEstime;

        return $this;
    }

    public function getStatusLiv(): ?string
    {
        return $this->statusLiv;
    }

    public function setStatusLiv(string $statusLiv): static
    {
        $this->statusLiv = $statusLiv;

        return $this;
    }

    public function getInfoSuivi(): ?string
    {
        return $this->infoSuivi;
    }

    public function setInfoSuivi(string $infoSuivi): static
    {
        $this->infoSuivi = $infoSuivi;

        return $this;
    }

    public function getModeLivraison(): ?string
    {
        return $this->modeLivraison;
    }

    public function setModeLivraison(string $modeLivraison): static
    {
        $this->modeLivraison = $modeLivraison;

        return $this;
    }

    

    public function getCart(): ?Cart
    {
        return $this->Cart;
    }

    public function setCart(?Cart $Cart): static
    {
        $this->Cart = $Cart;

        return $this;
    }
}
