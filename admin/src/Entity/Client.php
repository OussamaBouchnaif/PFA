<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ClientRepository::class)]

class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $password = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\Column(length: 20)]
    private ?string $statusCompte = null;

    #[ORM\Column(length: 20)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $pts_fidelite = null;

    #[ORM\Column(length: 120)]
    private ?string $addressLivSup = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: AvisCamera::class)]
    private Collection $avisCameras;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: FavoritCamera::class)]
    private Collection $favoritCameras;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private Collection $commandes;

    public function __construct()
    {
        
        $this->avisCameras = new ArrayCollection();
        $this->favoritCameras = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->adresse;
    }

    public function setAddress(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getStatusCompte(): ?string
    {
        return $this->statusCompte;
    }

    public function setStatusCompte(string $statusCompte): static
    {
        $this->statusCompte = $statusCompte;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPtsFidelite(): ?int
    {
        return $this->pts_fidelite;
    }

    public function setPtsFidelite(?int $pts_fidelite): static
    {
        $this->pts_fidelite = $pts_fidelite;

        return $this;
    }

    public function getAddressLivSup(): ?string
    {
        return $this->addressLivSup;
    }

    public function setAddressLivSup(string $addressLivSup): static
    {
        $this->addressLivSup = $addressLivSup;

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
            $avisCamera->setClient($this);
        }

        return $this;
    }

    public function removeAvisCamera(AvisCamera $avisCamera): static
    {
        if ($this->avisCameras->removeElement($avisCamera)) {
            // set the owning side to null (unless already changed)
            if ($avisCamera->getClient() === $this) {
                $avisCamera->setClient(null);
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
            $favoritCamera->setClient($this);
        }

        return $this;
    }

    public function removeFavoritCamera(FavoritCamera $favoritCamera): static
    {
        if ($this->favoritCameras->removeElement($favoritCamera)) {
            // set the owning side to null (unless already changed)
            if ($favoritCamera->getClient() === $this) {
                $favoritCamera->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getId();
    }
}
