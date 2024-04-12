<?php


namespace App\Service\Api\Query;

class PrepareQueryCamera implements PrepareQueryInterface
{
    private $queryString;

    public function __construct(QueryStringBuilder $queryString)
    {
        $this->queryString = $queryString;
    }
    
    public function prepareQueryString(array $searchCriteria): String
    {
        $queryStringBuilder = $this->queryString;

        foreach ($searchCriteria as $key => $value) {
            if (!is_null($value)) {
                switch ($key) {
                    case 'categorie.nom':
                        $queryStringBuilder = $queryStringBuilder->addCategorieNameParameter($value);
                        break;
                    case 'order':
                        $queryStringBuilder = $queryStringBuilder->addOrder($value);
                        break;
                    case 'resolution':
                        $queryStringBuilder = $queryStringBuilder->addResolution($value);
                        break;
                    case 'angleVision':
                        $queryStringBuilder = $queryStringBuilder->addAngleVision($value);
                        break;
                    case 'prix':
                        $queryStringBuilder = $queryStringBuilder->addPriceRangeParameter($value);
                        break;
                }
            }
        }

        return $queryStringBuilder->getQueryString();
    }
}
