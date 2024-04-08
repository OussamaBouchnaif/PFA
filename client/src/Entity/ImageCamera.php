<?php

namespace App\Entity;

use App\Repository\ImageCameraRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageCameraRepository::class)]
#[Vich\Uploadable]
class ImageCamera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'imageCameras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Camera $camera = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return  $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function __toString(): string
    {
        // Return a string that uniquely identifies the object, typically using an ID or a name
        return sprintf('ImageCamera (ID: %s)', $this->id);
    }

}
