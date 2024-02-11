<?php


namespace App\EntityListener;
use App\Entity\Client;
use App\Entity\Personne;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserListener {

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function prePersist(Personne $object)
    {
        $this->encodePassword($object,$object->getPlainPassword());
    }
    public function preUpdate(Personne $object)
    {
        $this->encodePassword($object,$object->getPlainPassword());
    }

    public function encodePassword(Personne $object,string $plainPassword)
    {
        
        if ($plainPassword !== null) {
            $hashedPassword = $this->hasher->hashPassword($object, $plainPassword);
            $object->setPassword($hashedPassword);
                
        }
    }
    

}