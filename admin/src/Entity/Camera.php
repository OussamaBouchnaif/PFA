<?php

namespace App\Entity;

use App\Repository\CameraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: CameraRepository::class)]


class Camera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['camera:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['camera:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 400)]
    #[Groups(['camera:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['camera:read'])]
    private ?float $prix = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['camera:read'])]
    private ?int $stock = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['camera:read'])]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\Column(length: 50, nullable: true)]
    
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: AvisCamera::class)]
    
    private Collection $avisCameras;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: FavoritCamera::class)]
    private Collection $favoritCameras;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: LigneCommande::class)]
    private Collection $ligneCommandes;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: ImageCamera::class)]
    #[Groups(['camera:read'])]
    private Collection $imageCameras;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: LigneReduction::class)]
    private Collection $ligneReductions;

    #[ORM\ManyToOne(inversedBy: 'cameras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function __construct()
    {
        $this->avisCameras = new ArrayCollection();
        $this->favoritCameras = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
        $this->imageCameras = new ArrayCollection();
        $this->ligneReductions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, AvisCamera>
     */
    public function getAvisCameras(): Collection
    {
        return $this->avisCameras;
    }

    public function addAvisCamera(AvisCamera $avisCamera): static
    {
        if (!$this->avisCameras->contains($avisCamera)) {
            $this->avisCameras->add($avisCamera);
            $avisCamera->setCamera($this);
        }

        return $this;
    }

    public function removeAvisCamera(AvisCamera $avisCamera): static
    {
        if ($this->avisCameras->removeElement($avisCamera)) {
            // set the owning side to null (unless already changed)
            if ($avisCamera->getCamera() === $this) {
                $avisCamera->setCamera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoritCamera>
     */
    public function getFavoritCameras(): Collection
    {
        return $this->favoritCameras;
    }

    public function addFavoritCamera(FavoritCamera $favoritCamera): static
    {
        if (!$this->favoritCameras->contains($favoritCamera)) {
            $this->favoritCameras->add($favoritCamera);
            $favoritCamera->setCamera($this);
        }

        return $this;
    }

    public function removeFavoritCamera(FavoritCamera $favoritCamera): static
    {
        if ($this->favoritCameras->removeElement($favoritCamera)) {
            // set the owning side to null (unless already changed)
            if ($favoritCamera->getCamera() === $this) {
                $favoritCamera->setCamera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): static
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->add($ligneCommande);
            $ligneCommande->setCamera($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): static
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCamera() === $this) {
                $ligneCommande->setCamera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImageCamera>
     */
    public function getImageCameras(): Collection
    {
        return $this->imageCameras;
    }

    public function addImageCamera(ImageCamera $imageCamera): static
    {
        if (!$this->imageCameras->contains($imageCamera)) {
            $this->imageCameras->add($imageCamera);
            $imageCamera->setCamera($this);
        }

        return $this;
    }

    public function removeImageCamera(ImageCamera $imageCamera): static
    {
        if ($this->imageCameras->removeElement($imageCamera)) {
            // set the owning side to null (unless already changed)
            if ($imageCamera->getCamera() === $this) {
                $imageCamera->setCamera(null);
            }
        }

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
            $ligneReduction->setCamera($this);
        }

        return $this;
    }

    public function removeLigneReduction(LigneReduction $ligneReduction): static
    {
        if ($this->ligneReductions->removeElement($ligneReduction)) {
            // set the owning side to null (unless already changed)
            if ($ligneReduction->getCamera() === $this) {
                $ligneReduction->setCamera(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
