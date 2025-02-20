<?php

namespace App\Entity;

use App\Repository\AvisCameraRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisCameraRepository::class)]
class AvisCamera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $note = null;

    #[ORM\Column(length: 400)]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'avisCameras')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'avisCameras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Camera $camera = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): static
    {
        $this->client = $client;

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
