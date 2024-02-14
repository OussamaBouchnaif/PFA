<?php

namespace App\Entity;

use App\Repository\LigneReductionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneReductionRepository::class)]
class LigneReduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneReductions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reduction $reduction = null;

    #[ORM\ManyToOne(inversedBy: 'ligneReductions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Camera $camera = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReduction(): ?Reduction
    {
        return $this->reduction;
    }

    public function setReduction(?Reduction $reduction): static
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getCamera(): ?Camera
    {
        return $this->camera;
    }

    public function setCamera(?Camera $camera): static
    {
        $this->camera = $camera;

        return $this;
    }
}
