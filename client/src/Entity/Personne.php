<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


#[ORM\MappedSuperclass]
abstract class Personne 
{
   

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:50)]
    protected ?string $nom = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:50)]
    protected ?string $prenom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    protected ?string $password = null;

    protected ?string $plainPassword = null;

    #[ORM\Column]
    protected array $roles = [];

   
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
