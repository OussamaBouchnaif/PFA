<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Camera;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\CodePromo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class OrderFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['order'];
    }
    public function load(ObjectManager $manager): void
    {
       
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) 
        {
            $client = new Client();
            $client->setNom($faker->lastName);
            $client->setPrenom($faker->firstName);
            $client->setEmail($faker->email);
            $client->setPassword($faker->password); // À remplacer par la méthode appropriée pour générer un mot de passe sécurisé
            $client->setAdresse($faker->streetAddress);
            $client->setDateInscription($faker->dateTimeThisDecade);
            $client->setStatusCompte($faker->randomElement(['actif', 'inactif'])); // Choix aléatoire entre 'actif' et 'inactif'
            $client->setVille($faker->city);
            $client->setPtsFidelite($faker->numberBetween(1, 1000)); // Nombre aléatoire entre 1 et 1000
            $client->setAddressLivSup($faker->streetAddress);

            $code = new CodePromo();
            $code->setCode(substr($faker->word, 0, 10));
            $code->setDescription("Static description for testing");
            $code->setPourcentage($faker->numberBetween(1, 50));
            $code->setDateExpiration($faker->dateTimeBetween('now', '+1 year'));
            $code->setNombreAutorisation($faker->numberBetween(1, 10));
            $code->setStatus($faker->randomElement(['Actif', 'Inactif']));

            $commande = new Commande();
            $commande->setDateCommande($faker->dateTimeThisYear);
            $commande->setStatus($faker->randomElement(['En cours', 'Terminée', 'Annulée']));
            $commande->setTotal($faker->randomFloat(2, 50, 500)); // Montant total aléatoire entre 50 et 500
            $commande->setClient($client);
            $commande->setCodePromo($code);

            $manager->persist($client);
            $manager->persist($code);
            $manager->persist($commande);
        }
        $manager->flush();
    }

   
}
