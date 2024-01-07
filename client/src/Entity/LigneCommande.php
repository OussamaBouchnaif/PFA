<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]

class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $qte = null;

    #[ORM\Column]
    private ?float $prixInitial = null;

    #[ORM\Column]
    private ?float $prixPromo = null;

    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Camera $camera = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getPrixInitial(): ?float
    {
        return $this->prixInitial;
    }

    public function setPrixInitial(float $prixInitial): static
    {
        $this->prixInitial = $prixInitial;

        return $this;
    }

    public function getPrixPromo(): ?float
    {
        return $this->prixPromo;
    }

    public function setPrixPromo(float $prixPromo): static
    {
        $this->prixPromo = $prixPromo;

        return $this;
    }

    public function getCommande(): ?commande
    {
        return $this->commande;
    }

    public function setCommande(?commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getCamera(): ?camera
    {
        return $this->camera;
    }

    public function setCamera(?camera $camera): static
    {
        $this->camera = $camera;

        return $this;
    }
}
