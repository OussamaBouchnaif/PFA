<?php


namespace App\DTO;

use App\Entity\Categorie;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class CameraDTO 
{

    public ?int $id = null;


    public ?string $nom = null;

    public ?string $description = null;


    public ?float $prix = null;

    public ?int $stock = null;

    public ?\DateTimeInterface $dateAjout = null;


    public ?string $status = null;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======


    public Collection $favoritCameras;


    public Collection $ligneCommandes;


>>>>>>> 9bb638e (conflit data)
=======
>>>>>>> 535ed5b (data)
=======
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
    public array  $imageCameras= [];

    public Collection $ligneReductions;

   

    public ?Categorie $categorie = null;


    public ?string $couleur = null;


    public ?bool $visionNoctrune = null;


    public ?float $poids = null;


    public ?string $materiaux = null;


    public ?string $resolution = null;


    public ?string $angleVision = null;

  
    public ?bool $connectivite = null;


    public ?float $stockage = null;


    public ?string $alimentation = null;

    public Collection $blogs;

  

}