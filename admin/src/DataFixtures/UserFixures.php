<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getGroups(): array
    {
        return ['order'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) { // Générer 20 utilisateurs de test
            $user = new User();
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setEmail($faker->email);
            // Générer un mot de passe hashé pour chaque utilisateur
            $hashedPassword = $this->passwordEncoder->encodePassword($user, 'password123');
            $user->setPassword($hashedPassword);
            // Autres propriétés d'utilisateur à définir selon vos besoins
            $user->setRoles(['ROLE_USER']); // Exemple de rôle pour l'utilisateur

            $manager->persist($user);
        }

        $manager->flush();
    }
}
