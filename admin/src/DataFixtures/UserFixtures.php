<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher =$hasher;

    }


    public static function getGroups(): array
    {
        return ['user'];
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

<<<<<<< HEAD
        // Load data for User entity

        for ($i = 0; $i < 3; $i++) {
            $user = new User();

=======

      
            $user = new User();
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
            $user->setNom('yassine');
            $user->setPrenom('chidmi');
            $user->setEmail('yassine@gmail.com'); // Ensure unique email addresses
            $hashedPassword = $this->hasher->hashPassword($user, 'yassine');
<<<<<<< HEAD

=======
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
            $user->setPassword($hashedPassword); // Replace 'password' with hashed passwords in real scenarios
            $user->setRoles(['ROLE_USER']); // Set user roles as needed
            $user->setPhoneNumber('0640331796');
            $user->setImage($faker->image);
            $user->setVille('ville');
            $user->setGenre('etdfv');
            $manager->persist($user);
       

        $manager->flush();
    }
}
<<<<<<< HEAD
}
=======
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
