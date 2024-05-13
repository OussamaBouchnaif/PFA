<?php


namespace App\DTO;

use App\Entity\Camera;
use App\Entity\Categorie;
use App\Entity\AvisCamera;

class CameraDTO
{

    private  ?int $id = null;


    private  ?string $nom = null;

    private  ?string $description = null;

    private  ?float $prix = null;

    private  ?int $stock = null;

    private  ?\DateTimeInterface $dateAjout = null;

    private  ?string $status = null;

    private  array  $imageCameras = [];

    private  array $ligneReductions = [];
    private  array  $avisCameras = [];

    private  ?Categorie $categorie = null;

    private  ?string $couleur = null;

    private  ?bool $visionNoctrune = null;

    private  ?float $poids = null;

    private  ?string $materiaux = null;

    private  ?string $resolution = null;

    private  ?string $angleVision = null;

    private  ?bool $connectivite = null;

    private  ?float $stockage = null;

    private  ?string $alimentation = null;

   
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of prix
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     *
     * @return  self
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of dateAjout
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set the value of dateAjout
     *
     * @return  self
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of imageCameras
     */
    public function getImageCameras()
    {
        return $this->imageCameras;
    }

    /**
     * Set the value of imageCameras
     *
     * @return  self
     */
    public function setImageCameras($imageCameras)
    {
        $this->imageCameras = $imageCameras;

        return $this;
    }

    /**
     * Get the value of ligneReductions
     */
    public function getLigneReductions()
    {
        return $this->ligneReductions;
    }

    /**
     * Set the value of ligneReductions
     *
     * @return  self
     */
    public function setLigneReductions($ligneReductions)
    {
        $this->ligneReductions = $ligneReductions;

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

    /**
     * Get the value of categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set the value of categorie
     *
     * @return  self
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get the value of couleur
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set the value of couleur
     *
     * @return  self
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get the value of visionNoctrune
     */
    public function getVisionNoctrune()
    {
        return $this->visionNoctrune;
    }

    /**
     * Set the value of visionNoctrune
     *
     * @return  self
     */
    public function setVisionNoctrune($visionNoctrune)
    {
        $this->visionNoctrune = $visionNoctrune;

        return $this;
    }

    /**
     * Get the value of poids
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * Set the value of poids
     *
     * @return  self
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get the value of materiaux
     */
    public function getMateriaux()
    {
        return $this->materiaux;
    }

    /**
     * Set the value of materiaux
     *
     * @return  self
     */
    public function setMateriaux($materiaux)
    {
        $this->materiaux = $materiaux;

        return $this;
    }

    /**
     * Get the value of resolution
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * Set the value of resolution
     *
     * @return  self
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * Get the value of angleVision
     */
    public function getAngleVision()
    {
        return $this->angleVision;
    }

    /**
     * Set the value of angleVision
     *
     * @return  self
     */
    public function setAngleVision($angleVision)
    {
        $this->angleVision = $angleVision;

        return $this;
    }

    /**
     * Get the value of connectivite
     */
    public function getConnectivite()
    {
        return $this->connectivite;
    }

    /**
     * Set the value of connectivite
     *
     * @return  self
     */
    public function setConnectivite($connectivite)
    {
        $this->connectivite = $connectivite;

        return $this;
    }

    /**
     * Get the value of stockage
     */
    public function getStockage()
    {
        return $this->stockage;
    }

    /**
     * Set the value of stockage
     *
     * @return  self
     */
    public function setStockage($stockage)
    {
        $this->stockage = $stockage;

        return $this;
    }

    /**
     * Get the value of alimentation
     */
    public function getAlimentation()
    {
        return $this->alimentation;
    }

    /**
     * Set the value of alimentation
     *
     * @return  self
     */
    public function setAlimentation($alimentation)
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getNotes(): array
    {
        return array_map(function ($avis) {
            return $avis['note'];
        }, $this->getAvisCameras());
    }

    public function calculatingTheAverage()
    {
        $totalNotes = $this->totalNotes();
        $sumNotes =  array_sum($this->getNotes());

        return $totalNotes > 0 ? round($sumNotes / $totalNotes) : 0;
    }
    public function totalNotes():int
    {
        return count($this->getNotes());
    }

    public function toCamera(): Camera {
        
        $camera = new Camera();
        $camera->setPrix($this->getPrix()); 
    
        return $camera;
    }
}
