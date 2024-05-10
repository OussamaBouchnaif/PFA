<?php

namespace App\Service\Session;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionManager implements SessionManagerInterface
{
    public function __construct(private RequestStack $request)
    {
        
    }
    public function fillInTheSession($newCriteria):array
    {
        $session = $this->request->getSession();
        $searchCriteria = $session->get('searchCriteria', array());
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
        return $searchCriteria;
    }
}
