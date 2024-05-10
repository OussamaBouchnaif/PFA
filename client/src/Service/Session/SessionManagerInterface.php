<?php

namespace App\Service\Session;

interface SessionManagerInterface
{
    /**
         * @param array $newCriteria The new search criteria to store in the session. 
         *        This array should include keys and values corresponding to the search parameters
         *        (e.g., 'order', 'resolution', 'categorie.nom', 'angleVision', 'prix').
         * @return array Returns the updated array of criteria that has been stored in the session.
     */
    public function fillInTheSession($newCriteria): array;
}
