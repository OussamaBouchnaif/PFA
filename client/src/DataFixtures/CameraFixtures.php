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
    public function load(ObjectManager $manager):void
    {
        $faker = Factory::create();

        for($i = 0; $i<10;$i++)
        {
            $categorie = new Categorie();
            $categorie->setNom($faker->word);
            $categorie->setDescription("Static description for testing");

            $camera = new Camera();
            $camera->setNom($faker->word);
            $camera->setDescription("Static description for testing");
            $camera->setPrix($faker->randomFloat(2, 50, 500)); // Adjust the range based on your needs
            $camera->setStock($faker->numberBetween(1, 100));
            $camera->setDateAjout($faker->dateTimeThisYear);
            $camera->setStatus($faker->randomElement(['available', 'out_of_stock', 'preorder']));
            $camera->setCategorie($categorie);
            
            $manager->persist($categorie);
            $manager->persist($camera);
            

        }
        $manager->flush();
    }
    
}
