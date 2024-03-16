<?php

namespace App\Controller;


use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PannierController extends AbstractController
{
    #[Route('AddPannier',name:'add_pannier')]
    public function addPannier(): Response
    {
        return $this->render('');
    }
}