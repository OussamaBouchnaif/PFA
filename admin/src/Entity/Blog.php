<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255)]
    private ?string $imageCoverture = null;

    #[ORM\ManyToOne(inversedBy: 'blogs')]
    private ?User $User = null;

    #[ORM\ManyToMany(targetEntity: Camera::class, inversedBy: 'blogs')]
    private Collection $Camera;

    public function __construct()
    {
        $this->Camera = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImageCoverture(): ?string
    {
        return $this->imageCoverture;
    }

    public function setImageCoverture(string $imageCoverture): static
    {
        $this->imageCoverture = $imageCoverture;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Camera>
     */
    public function getCamera(): Collection
    {
        return $this->Camera;
    }

    public function addCamera(Camera $camera): static
    {
        if (!$this->Camera->contains($camera)) {
            $this->Camera->add($camera);
        }

        return $this;
    }

    public function removeCamera(Camera $camera): static
    {
        $this->Camera->removeElement($camera);

        return $this;
    }
}
