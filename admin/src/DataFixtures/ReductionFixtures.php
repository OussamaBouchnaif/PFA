<?php

// src/DataFixtures/ReductionFixtures.php

namespace App\DataFixtures;

use App\Entity\Reduction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReductionFixtures extends Fixture
{
    public static function getGroups(): array
    {
        return ['reduc'];
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) { // Vous pouvez ajuster le nombre de fausses données que vous souhaitez générer
            $reduction = new Reduction();
            $reduction->setDescription($faker->sentence());
            $reduction->setPoucentage($faker->numberBetween(5, 50)); // Vous pouvez ajuster les valeurs minimales et maximales
            $reduction->setDateDebut($faker->dateTimeBetween('-1 month', 'now'));
            $reduction->setDateFin($faker->dateTimeBetween('now', '+1 month'));

            $manager->persist($reduction);
        }

        $manager->flush();
    }
}
