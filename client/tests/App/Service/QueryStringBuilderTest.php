<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\Service\Api\Query\QueryStringBuilder;
use PHPUnit\Framework\TestCase;

class QueryStringBuilderTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testGetQueryString(QueryStringBuilder $queryBuilder, string $expectedString): void
    {
        $this->assertEquals($queryBuilder->getQueryString(), $expectedString);
    }

    public function getDataProvider(): array
    {
        return [
            [
                (new QueryStringBuilder())
                    ->appendParameter('param', 'value')
                    ->addPriceRangeParameter(200.0, 400.0)
                    ->setLimitPerPage(10)
                    ->setPage(1),
                'param=value&prix%5Bbetween%5D=200..400&itemsPerPage=10&page=1',
            ],
            [
                (new QueryStringBuilder())
                    ->addGreatherThanPriceParameter(200.0)
                    ->setLimitPerPage(10)
                    ->setPage(1),
                'prix%5Bgte%5D=200&itemsPerPage=10&page=1',
            ],
            [
                (new QueryStringBuilder())
                    ->addGreatherThanPriceParameter(200.0, true)
                    ->setLimitPerPage(10)
                    ->setPage(1),
                'prix%5Bgt%5D=200&itemsPerPage=10&page=1',
            ],
            [
                (new QueryStringBuilder())
                    ->addLessThanPriceParameter(200.0, true)
                    ->setLimitPerPage(10)
                    ->setPage(1),
                'prix%5Blt%5D=200&itemsPerPage=10&page=1',
            ],
            [
                (new QueryStringBuilder())
                    ->addLessThanPriceParameter(200.0)
                    ->setLimitPerPage(10)
                    ->setPage(1)
                    ->addOrder('field'),
                'prix%5Blte%5D=200&itemsPerPage=10&page=1&order%5Bfield%5D=asc',
            ],
        ];
    }
}
