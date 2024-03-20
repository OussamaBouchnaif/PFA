<?php

declare(strict_types=1);

namespace App\Service\Api\Query;

class QueryStringBuilder
{
    private array $query = [];

    public function __construct()
    {
    }

    public function addLessThanPriceParameter(float $max, bool $strict = false): static
    {
        $operation = true === $strict ? 'lt' : 'lte';

        $this->appendParameter('prix[' . $operation . ']', $max);

        return $this;
    }

    public function addGreatherThanPriceParameter(float $min, bool $strict = false): static
    {
        $operation = true === $strict ? 'gt' : 'gte';

        $this->appendParameter('prix[' . $operation . ']', $min);

        return $this;
    }

<<<<<<< HEAD
    public function addPriceRangeParameter(float $min, float $max): static
    {
        $this->appendParameter('prix[between]', $min . '..' . $max);
=======
    public function addPriceRangeParameter(string $price): static
    {
        $this->appendParameter('prix[between]', $price);
>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033

        return $this;
    }

<<<<<<< HEAD
=======
    public function addCategorieNameParameter(string $name):static
    {
        $this->appendParameter('categorie.nom',$name);
        return $this;

    }

    public function addResolution(string $resolution):static
    {
        $this->appendParameter('resolution',$resolution);
        return $this;
    }

    public function addAngleVision(string $angleVision):static
    {
        $this->appendParameter('angleVision',$angleVision);
        return $this;
    }

>>>>>>> 1fd586260a7ea8d9dec1a406ae3ebede689e1033
    public function addOrder(string $orderBy): static
    {
        $this->appendParameter('order[' . $orderBy . ']', 'asc');

        return $this;
    }

    public function setPage(int $page): static
    {
        $this->appendParameter('page', $page);

        return $this;
    }

    public function setLimitPerPage(int $limit): static
    {
        $this->appendParameter('itemsPerPage', $limit);

        return $this;
    }

    public function appendParameter(mixed $parameterName, mixed $parameterValue): static
    {
        $this->query[$parameterName] =  $parameterValue;

        return $this;
    }

    public function getQueryString(): string
    {
        return \http_build_query($this->query);
    }
}
