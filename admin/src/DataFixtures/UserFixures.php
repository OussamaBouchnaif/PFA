<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['user'];
    
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Load data for Personne entity
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword('password'); // Replace 'password' with hashed passwords in real scenarios
            $user->setRoles(['ROLE_USER']); // Set user roles as needed
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword('password'); // Replace 'password' with hashed passwords in real scenarios
            $user->setRoles(['ROLE_USER']); // Set user roles as needed
            // Set other properties of the User entity as needed
            $manager->persist($user);
        }

        $manager->flush();
    }

   
}
