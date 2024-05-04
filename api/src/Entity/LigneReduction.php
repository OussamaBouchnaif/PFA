<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LigneReductionRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneReductionRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['LigneReduction:read']])]
class LigneReduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneReductions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['LigneReduction:read','camera:read'])]
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
