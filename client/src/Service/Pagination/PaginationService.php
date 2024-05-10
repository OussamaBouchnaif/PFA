<?php

namespace App\Service\Pagination;

use Knp\Component\Pager\PaginatorInterface;

class PaginationService implements PaginationServiceInterface
{
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Paginates the given query or array.
     *
     */
    public function paginate($source, int $page, int $limit = 9)
    {
        return $this->paginator->paginate(
            $source,
            $page,
            $limit
        );
    }

    /**
     * Extracts pagination information.
     *
     */
    public function extractPaginationInfo(int $totalItems, int $page, int $limit = 9)
    {
        $totalPages = ceil($totalItems / $limit);
        return [
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }
}
