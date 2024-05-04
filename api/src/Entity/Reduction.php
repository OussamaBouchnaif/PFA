<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReductionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ReductionRepository::class)]
#[ApiResource(normalizationContext:['groups'=>['reduction:read']])]
class Reduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 300)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['reduction:read','ligneReduction:read','camera:read'])]
    private ?int $poucentage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['reduction:read','ligneReduction:read','camera:read'])]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['reduction:read','ligneReduction:read','camera:read'])]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\OneToMany(mappedBy: 'reduction', targetEntity: LigneReduction::class)]
    private Collection $ligneReductions;

    public function __construct()
    {
        $this->ligneReductions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPoucentage(): ?int
    {
        return $this->poucentage;
    }

    public function setPoucentage(int $poucentage): static
    {
        $this->poucentage = $poucentage;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection<int, LigneReduction>
     */
    public function getLigneReductions(): Collection
    {
        return $this->ligneReductions;
    }

    public function addLigneReduction(LigneReduction $ligneReduction): static
    {
        if (!$this->ligneReductions->contains($ligneReduction)) {
            $this->ligneReductions->add($ligneReduction);
            $ligneReduction->setReduction($this);
        }

        return $this;
    }

    public function removeLigneReduction(LigneReduction $ligneReduction): static
    {
        if ($this->ligneReductions->removeElement($ligneReduction)) {
            // set the owning side to null (unless already changed)
            if ($ligneReduction->getReduction() === $this) {
                $ligneReduction->setReduction(null);
            }
        }

        return $this;
    }
}
