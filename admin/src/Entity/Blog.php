<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
#[Vich\Uploadable]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide")]
    #[Assert\Length(max: 255, maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères")]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "Le contenu ne peut pas être vide")]
    private ?string $contenu = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $imageCoverture = null;

    // #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageCoverture')]
    // #[Assert\File(
    //     maxSize: '5M',
    //     mimeTypes: ['image/jpeg', 'image/png'],
    //     maxSizeMessage: "Le fichier ne peut pas dépasser {{ limit }}",
    //     mimeTypesMessage: "Seuls les fichiers JPEG et PNG sont autorisés"
    // )]
    // private ?File $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'blogs')]
    #[Assert\NotNull(message: "L'utilisateur doit être spécifié")]
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

    // public function getImageCoverture(): ?string
    // {
    //     return $this->imageCoverture;
    // }

    // public function setImageCoverture(string $imageCoverture): static
    // {
    //     $this->imageCoverture = $imageCoverture;

    //     return $this;
    // }

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

    // public function getImageFile(): ?File
    // {
    //     return $this->imageFile;
    // }

    // public function setImageFile(?File $imageFile): void
    // {
    //     $this->imageFile = $imageFile;
    // }
}