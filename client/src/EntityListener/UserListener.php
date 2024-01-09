<?php


namespace App\EntityListener;
use App\Entity\Client;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserListener {

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function prePersist(object $object)
    {
        $this->encodePassword($object);
    }
    public function preUpdate(object $object)
    {
        $this->encodePassword($object);
    }

    public function encodePassword($object)
    {
        if ($object instanceof Client) {
            $plainPassword = $object->getPlainPassword();
            if ($plainPassword !== null) {
                $hashedPassword = $this->hasher->hashPassword($object, $plainPassword);
                $object->setPassword($hashedPassword);
                 
            }
        }
    }
    

}