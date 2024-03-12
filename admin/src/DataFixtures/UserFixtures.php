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


      
            $user = new User();
            $user->setNom('yassine');
            $user->setPrenom('chidmi');
            $user->setEmail('yass@gmail.com'); // Ensure unique email addresses
            $hashedPassword = $this->hasher->hashPassword($user, '123');
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
