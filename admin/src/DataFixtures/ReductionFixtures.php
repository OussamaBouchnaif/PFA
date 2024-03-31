<?php


namespace App\DataFixtures;

use App\Entity\Reduction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReductionFixtures extends Fixture
{
    public static function getGroups(): array
    {
        return ['Reduction'];
    }
    public function load(ObjectManager $manager)
    {
        // $faker = Factory::create();

        // // Création de 10 réductions factices
        // for ($i = 0; $i < 10; $i++) {
        //     $reduction = new Reduction();
        //     $reduction->setDescription($faker->sentence());
        //     $reduction->setPoucentage($faker->numberBetween(5, 50)); // Poucentage aléatoire entre 5 et 50
        //     $reduction->setDateDebut($faker->dateTimeBetween('-1 year', 'now'));
        //     $reduction->setDateFin($faker->dateTimeBetween('now', '+1 year'));

        //     $manager->persist($reduction);
        // }

        // $manager->flush();
    }
}
