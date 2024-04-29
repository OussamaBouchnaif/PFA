<?php


namespace App\EntityListener;
use App\Entity\Personne;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        if ($plainPassword === null) {
            return;
        }
        if ($plainPassword !== null) {
            $hashedPassword = $this->hasher->hashPassword($object, $plainPassword);
            $object->setPassword($hashedPassword);
                
        }
    }
    

}