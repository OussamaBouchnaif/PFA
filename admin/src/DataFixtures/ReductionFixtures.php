<?php

namespace App\DataFixtures;

use App\Entity\Reduction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReductionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $reduction = new Reduction();
            $reduction->setDescription($faker->sentence(6, true));
            $reduction->setPoucentage($faker->numberBetween(0, 100));
            $dateDebut = $faker->dateTimeBetween('-1 year', 'now');
            $dateFin = $faker->dateTimeBetween($dateDebut, '+1 year');
            $reduction->setDateDebut($dateDebut);
            $reduction->setDateFin($dateFin);

            $manager->persist($reduction);
        }

        $manager->flush();
    }
}
