<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Camera;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Categorie;
use App\Entity\CodePromo;
use App\Entity\ImageCamera;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CameraFixtures extends Fixture implements FixtureGroupInterface
{
    
    public static function getGroups(): array
    {
        return ['camera'];
    
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $categorie = new Categorie();
            $categorie->setNom($faker->word);
            $categorie->setDescription("Static description for testing");

            $camera = new Camera();
            $camera->setNom($faker->word);
            $camera->setDescription("Static description for testing");
            $camera->setPrix($faker->randomFloat(2, 50, 500)); // Ajustez la plage en fonction de vos besoins
            $camera->setStock($faker->numberBetween(1, 100));
            $camera->setDateAjout($faker->dateTimeThisYear);
            $camera->setStatus($faker->randomElement(['available', 'out_of_stock', 'preorder']));
            $camera->setCategorie($categorie);
            $camera->setCouleur($faker->colorName);
            $camera->setVisionNoctrune($faker->boolean); 
            $camera->setPoids($faker->randomFloat(2, 0.1, 5));
            $camera->setMateriaux($faker->word);
            $camera->setResolution($faker->randomElement(['720p', '1080p', '4K']));
            $camera->setAngleVision($faker->numberBetween(90, 180) . '°');
            $camera->setConnectivite($faker->boolean);
            $camera->setStockage($faker->randomFloat(2, 16, 512));
            $camera->setAlimentation($faker->randomElement(['Battery', 'Solar', 'AC Power']));
            $manager->persist($categorie);
            $manager->persist($camera);
        }
        
        $manager->flush();
    }
}
