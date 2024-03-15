<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Personne;


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

=======
        // Load data for User entity
<<<<<<< HEAD
>>>>>>> 779ae00 (edit and add user)
      
            $user = new User();
            $user->setNom('yassine');
            $user->setPrenom('chidmi');
<<<<<<< HEAD
            $user->setEmail('yassine@gmail.com'); // Ensure unique email addresses
            $hashedPassword = $this->hasher->hashPassword($user, 'yassine');
=======
            $user->setEmail('yass@gmail.com'); // Ensure unique email addresses
=======

        for ($i = 0; $i < 3; $i++) {
            $user = new User();
<<<<<<< HEAD
            $user->setNom('yfv');
            $user->setPrenom('rvfv');
            $user->setEmail('oussama@gmail.com'); // Ensure unique email addresses

>>>>>>> fdc8b02 (add reviews to a specific camera)
            $hashedPassword = $this->hasher->hashPassword($user, '123');
<<<<<<< HEAD
>>>>>>> 779ae00 (edit and add user)
=======
=======
            $user->setNom('yassine');
            $user->setPrenom('chidmi');
            $user->setEmail('yassine@gmail.com'); // Ensure unique email addresses
            $hashedPassword = $this->hasher->hashPassword($user, 'yassine');
>>>>>>> d674604 (login)
>>>>>>> d9550c0 (login)
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
}