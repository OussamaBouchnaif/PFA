<?php
// src/Entity/ImageCamera.php

namespace App\Entity;

use App\Repository\ImageCameraRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageCameraRepository::class)]
#[Vich\Uploadable]
class ImageCamera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = '';

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'image')]
    private ?File $imageFile;

    #[ORM\ManyToOne(inversedBy: 'imageCameras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Camera $camera;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCamera(): ?Camera
    {
        return $this->camera;
    }

    public function setCamera(?Camera $camera): self
    {
        $this->camera = $camera;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
