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

    public function addPriceRangeParameter(float $min, float $max): static
    {
        $this->appendParameter('prix[between]', $min . '..' . $max);

        return $this;
    }
    public function addCategorieNameParameter(string $name):static
    {
        $this->appendParameter('categorie.nom',$name);
        return $this;

    }

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
