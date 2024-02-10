<?php


namespace App\EntityListener;
use App\Entity\Client;
use App\Entity\Personne;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserListener {

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function prePersist(Personne $object)
    {
        $this->encodePassword($object);
    }
    public function preUpdate(Personne $object)
    {
        $this->encodePassword($object);
    }

    public function encodePassword($object)
    {
        $plainPassword = $object->getPlainPassword();
        if ($plainPassword !== null) {
            $hashedPassword = $this->hasher->hashPassword($object, $plainPassword);
            $object->setPassword($hashedPassword);
                
        }
    }
    

}