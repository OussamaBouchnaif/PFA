<?php

namespace App\Service\Pagination;

interface PaginationServiceInterface
{
   
    /**
         * Paginates the given query or array.
         *
         * @param mixed $source Data source for pagination.
         * @param int $page Current page number.
         * @param int $limit Number of items per page.
         * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function paginate($source, int $page, int $limit = 9);
    
    /**
         * Extracts pagination information.
         *
         * @param int $totalItems Total number of items.
         * @param int $page Current page number.
         * @param int $limit Number of items per page.
         * @return array
     */
    public function extractPaginationInfo(int $totalItems, int $page, int $limit = 9);
}
