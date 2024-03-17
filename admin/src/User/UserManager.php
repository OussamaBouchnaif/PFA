<?php

namespace App\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class UserManager
{   
    public function __construct(private readonly EntityManagerInterface $manager)
    {

    }

    public function saveUser(User $user, bool $mustPersist = false): void
    {
        $repository = $this->manager->getRepository(User::class);

        $repository->saveUser($user, $mustPersist);
    }

    public function removeUser(User $user): void
    {
        $repository = $this->manager->getRepository(User::class);

        $repository->deleteUser($user);
    }
}
