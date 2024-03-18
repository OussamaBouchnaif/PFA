<?php

namespace App\Factory;

class Factory
{
    public function create(string $className)
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("La classe $className n'existe pas.");
        }

        return new $className();
    }
}