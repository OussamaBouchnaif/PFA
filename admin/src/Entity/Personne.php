<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\MappedSuperclass]
abstract class Personne implements UserInterface, PasswordAuthenticatedUserInterface
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
