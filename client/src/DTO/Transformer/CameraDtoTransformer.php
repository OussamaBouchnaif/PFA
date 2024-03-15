<?php

namespace App\DTO\Transformer;

use App\DTO\CameraDTO;
use App\Entity\Camera;

class CameraDtoTransformer
{

    public function transformFromObject($camera): CameraDTO
    {


        $dto = new CameraDTO();
        $dto->email = $customer->getEmail();
        $dto->phoneNumber = $customer->getPhoneNumber();

        $camera->nom = ($faker->word);
        $camera->setDescription("Static description for testing");
        $camera->setPrix($faker->randomFloat(2, 50, 500)); // Adjust the range based on your needs
        $camera->setStock($faker->numberBetween(1, 100));
        $camera->setDateAjout($faker->dateTimeThisYear);
        $camera->setStatus($faker->randomElement(['available', 'out_of_stock', 'preorder']));
        $camera->setCategorie($categorie);

        return $dto;
    }
}