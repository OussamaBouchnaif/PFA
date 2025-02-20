<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\CameraRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CameraRepository::class)]
#[ApiResource(
        
        normalizationContext: ['groups' => ['camera:read']],
        denormalizationContext: ['groups' => ['camera:write']],
        paginationEnabled: true,
        paginationItemsPerPage: 9,
    )]
#[ApiFilter(SearchFilter::class, 
        properties: ['categorie.nom' => 'exact','angleVision'=>'exact','resolution' => 'exact','connectivite'=> 'exact'],
        
         )]
#[ApiFilter(RangeFilter::class, properties: ['prix'])]
#[ApiFilter(OrderFilter::class, properties: ['prix' => 'ASC','dateAjout'=>'ASC'])]
class Camera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['camera:read'])]
    public ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 400)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['camera:read','camera:write'])]
    private ?float $prix = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['camera:read','camera:write'])]
    private ?int $stock = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['camera:read','camera:write'])]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: CartItem::class)]
    private Collection $cartItem;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: ImageCamera::class)]
    #[Groups(['camera:read','camera:write'])]
    private Collection $imageCameras;

    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: LigneReduction::class)]
    #[Groups(['camera:read'])]
    private Collection $ligneReductions;
    
    #[ORM\OneToMany(mappedBy: 'camera', targetEntity: AvisCamera::class)]
    #[Groups(['camera:read'])]
    private Collection $avisCameras;

    #[ORM\ManyToOne(inversedBy: 'cameras')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['camera:read','camera:write'])]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 40)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $couleur = null;

    #[ORM\Column]
    #[Groups(['camera:read','camera:write'])]
    private ?bool $visionNoctrune = null;

    #[ORM\Column]
    #[Groups(['camera:read','camera:write'])]
    private ?float $poids = null;

    #[ORM\Column(length: 200)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $materiaux = null;

    #[ORM\Column(length: 40)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $resolution = null;

    #[ORM\Column(length: 20)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $angleVision = null;

    #[ORM\Column]
    #[Groups(['camera:read','camera:write'])]
    private ?bool $connectivite = null;

    #[ORM\Column]
    #[Groups(['camera:read','camera:write'])]
    private ?float $stockage = null;

    #[ORM\Column(length: 40)]
    #[Groups(['camera:read','camera:write'])]
    private ?string $alimentation = null;



    public function __construct()
    {
        $this->cartItem = new ArrayCollection();
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
     * Get the value of cartItem
     */ 
    public function getCartItem()
    {
        return $this->cartItem;
    }

    /**
     * Set the value of cartItem
     *
     * @return  self
     */ 
    public function setCartItem($cartItem)
    {
        $this->cartItem = $cartItem;

        return $this;
    }

    /**
     * Get the value of avisCameras
     */ 
    public function getAvisCameras()
    {
        return $this->avisCameras;
    }

    /**
     * Set the value of avisCameras
     *
     * @return  self
     */ 
    public function setAvisCameras($avisCameras)
    {
        $this->avisCameras = $avisCameras;

        return $this;
    }
}
