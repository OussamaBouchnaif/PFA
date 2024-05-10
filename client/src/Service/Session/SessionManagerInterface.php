<?php

namespace App\Service\Session;

interface SessionManagerInterface
{
    public function fillInTheSession($newCriteria):array;
}
