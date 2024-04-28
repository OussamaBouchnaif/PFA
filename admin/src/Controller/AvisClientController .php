<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisClientController extends AbstractController
{
    #[Route('/Avis', name: 'Avis_client')]
    public function avisClient(): Response
    {
        // Rendre la vue pour la page "Avis client"
        return $this->render('avis_client.html.twig');
    }
}
