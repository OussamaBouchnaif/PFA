<?php

namespace App\Entity;

use App\Repository\CameraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: CameraRepository::class)]

class Camera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 400)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $stock = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
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
    private Collection $imageCameras;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: LigneReduction::class)]
    private Collection $ligneReductions;

    #[ORM\ManyToOne(inversedBy: 'cameras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 40)]
    private ?string $couleur = null;

    #[ORM\Column]
    private ?bool $visionNoctrune = null;

    #[ORM\Column]
    private ?float $poids = null;

    #[ORM\Column(length: 200)]
    private ?string $materiaux = null;

    #[ORM\Column(length: 40)]
    private ?string $resolution = null;

    #[ORM\Column(length: 20)]
    private ?string $angleVision = null;

    #[ORM\Column]
    private ?bool $connectivite = null;

    #[ORM\Column]
    private ?float $stockage = null;

    #[ORM\Column(length: 40)]
    private ?string $alimentation = null;

    #[ORM\ManyToMany(targetEntity: Blog::class, mappedBy: 'Camera')]
    private Collection $blogs;

    public function __construct()
    {
        $this->avisCameras = new ArrayCollection();
        $this->favoritCameras = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
        $this->imageCameras = new ArrayCollection();
        $this->ligneReductions = new ArrayCollection();
        $this->blogs = new ArrayCollection();
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

    /**
     * Get the value of imageCameras
     */ 
    

    /**
     * Set the value of imageCameras
     *
     * @return  self
     */

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function isVisionNoctrune(): ?bool
    {
        return $this->visionNoctrune;
    }

    public function setVisionNoctrune(bool $visionNoctrune): static
    {
        $this->visionNoctrune = $visionNoctrune;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getMateriaux(): ?string
    {
        return $this->materiaux;
    }

    public function setMateriaux(string $materiaux): static
    {
        $this->materiaux = $materiaux;

        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(string $resolution): static
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getAngleVision(): ?string
    {
        return $this->angleVision;
    }

    public function setAngleVision(string $angleVision): static
    {
        $this->angleVision = $angleVision;

        return $this;
    }

    public function isConnectivite(): ?bool
    {
        return $this->connectivite;
    }

    public function setConnectivite(bool $connectivite): static
    {
        $this->connectivite = $connectivite;

        return $this;
    }

    public function getStockage(): ?float
    {
        return $this->stockage;
    }

    public function setStockage(float $stockage): static
    {
        $this->stockage = $stockage;

        return $this;
    }

    public function getAlimentation(): ?string
    {
        return $this->alimentation;
    }

    public function setAlimentation(string $alimentation): static
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    /**
     * @return Collection<int, Blog>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): static
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs->add($blog);
            $blog->addCamera($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): static
    {
        if ($this->blogs->removeElement($blog)) {
            $blog->removeCamera($this);
        }

        return $this;
    } 
    
}
