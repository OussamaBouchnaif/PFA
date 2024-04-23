<?php

declare(strict_types=1);

namespace App\Service\Api\Query;

class QueryStringBuilder
{
    private array $query = [];

    public function __construct()
    {
    }

    public function addPriceRangeParameter(?string $price = null): static
    {
        $this->appendParameter('prix[between]', $price);

        return $this;
    }

    public function addCategorieNameParameter(?string $name = null): static
    {
        $this->appendParameter('categorie.nom', $name);
        return $this ;
    }

    public function addResolution(?string $resolution = null): static
    {
        $this->appendParameter('resolution', $resolution);
        return $this;
    }

    public function addAngleVision(?string $angleVision = null): static
    {
        $this->appendParameter('angleVision', $angleVision);
        return $this;
    }

    public function addOrder(?string $orderBy = null): static
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

        return $this ?? null;
    }

    public function getQueryString(): string
    {
        return \http_build_query($this->query);
    }
}
