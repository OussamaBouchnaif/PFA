<?php

declare(strict_types=1);

namespace App\Service\Api\Query;

interface PrepareQueryInterface
{
    public function prepareQueryString(array $searchCriteria, int $page, int $itemsPerPage):String;
}