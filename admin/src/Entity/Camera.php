<?php

namespace App\Entity;

use App\Repository\CameraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CameraRepository::class)]
class Camera
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 100)]
    private $nom;

    #[ORM\Column(length: 400)]
    private $description;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'smallint')]
    private $stock;

    #[ORM\Column(type: 'date')]
    private $dateAjout;

    #[ORM\Column(length: 50, nullable: true)]
    private $status;

    #[Vich\UploadableField(mapping: 'camera_images', fileNameProperty: 'imageCameras')]
    private $imageFile;

            /**
         * @ORM\OneToMany(mappedBy="camera", targetEntity=ImageCamera::class)
         */
        private $imageCameras;
        /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
        /**
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    #[ORM\Column(length: 40)]
    private $couleur;

    #[ORM\Column(type: 'boolean')]
    private $visionNoctrune;

    #[ORM\Column(type: 'float')]
    private $poids;

    #[ORM\Column(length: 200)]
    private $materiaux;

    #[ORM\Column(length: 40)]
    private $resolution;

    #[ORM\Column(length: 20)]
    private $angleVision;

    #[ORM\Column(type: 'boolean')]
    private $connectivite;

    #[ORM\Column(type: 'float')]
    private $stockage;

    #[ORM\Column(length: 40)]
    private $alimentation;

    #[ORM\ManyToMany(targetEntity: Blog::class, mappedBy: 'Camera')]
    private $blogs;

    public function __construct()
    {
        $this->imageCameras = new ArrayCollection();
        
        $this->blogs = new ArrayCollection();
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
    

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
   

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            // Il est nécessaire de changer quelque chose dans l'entité pour que Doctrine puisse la mettre à jour
            $this->updatedAt = new \DateTime();
        }
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    
    public function setImageCameras($imageCameras): self
    {
        if ($imageCameras instanceof Collection || is_array($imageCameras)) {
            foreach ($imageCameras as $imageCamera) {
                $imageCamera->setCamera($this);
                $this->addImageCamera($imageCamera);
            }
        } elseif ($imageCameras === null) {
            // If $imageCameras is null, remove all existing associations
            foreach ($this->imageCameras as $imageCamera) {
                $imageCamera->setCamera(null);
                $this->removeImageCamera($imageCamera);
            }
        } else {
            throw new \InvalidArgumentException("setImageCameras expects an array or a Collection of ImageCamera objects.");
        }
    
        return $this;
    }
    


    /**
     * @return Collection|ImageCamera[]
     */
    public function getImageCameras(): Collection
    {
        return $this->imageCameras;
    }

    public function addImageCamera(ImageCamera $imageCamera): self
    {
        if (!$this->imageCameras->contains($imageCamera)) {
            $this->imageCameras[] = $imageCamera;
            $imageCamera->setCamera($this);
        }

        return $this;
    }

    public function removeImageCamera(ImageCamera $imageCamera): self
    {
        if ($this->imageCameras->removeElement($imageCamera)) {
            // set the owning side to null (unless already changed)
            if ($imageCamera->getCamera() === $this) {
                $imageCamera->setCamera(null);
            }
        }

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getVisionNoctrune(): ?bool
    {
        return $this->visionNoctrune;
    }

    public function setVisionNoctrune(bool $visionNoctrune): self
    {
        $this->visionNoctrune = $visionNoctrune;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getMateriaux(): ?string
    {
        return $this->materiaux;
    }

    public function setMateriaux(string $materiaux): self
    {
        $this->materiaux = $materiaux;

        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(string $resolution): self
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getAngleVision(): ?string
    {
        return $this->angleVision;
    }

    public function setAngleVision(string $angleVision): self
    {
        $this->angleVision = $angleVision;

        return $this;
    }

    public function getConnectivite(): ?bool
    {
        return $this->connectivite;
    }

    public function setConnectivite(bool $connectivite): self
    {
        $this->connectivite = $connectivite;

        return $this;
    }

    public function getStockage(): ?float
    {
        return $this->stockage;
    }

    public function setStockage(float $stockage): self
    {
        $this->stockage = $stockage;

        return $this;
    }

    public function getAlimentation(): ?string
    {
        return $this->alimentation;
    }

    public function setAlimentation(string $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->addCamera($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            $blog->removeCamera($this);
        }

        return $this;
    }
}
