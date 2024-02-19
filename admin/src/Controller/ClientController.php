<?php

namespace App\Controller;
use App\Entity\Client;
use App\Form\ClientStatusType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'client_list')]
    public function listClients(Request $request, ClientRepository $clientRepository, PaginatorInterface $paginator): Response
    {
        // Récupérer le numéro de la page 
        $page = $request->query->getInt('page', 1);

        $query = $clientRepository->createQueryBuilder('c')->getQuery();

        // Paginer 
        $pagination = $paginator->paginate(
            $query, 
            $page, 
            7 
        );

        // Rendre la vue avec la pagination
        return $this->render('dashboard/client/client_list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/clients/{id}/activate', name: 'client_activate')]
    public function activateClient(Client $client, EntityManagerInterface $entityManager): Response
    {
        // Activer 
        $client->setStatusCompte('active');
        $entityManager->flush();

        // Ajouter un message flash
        $this->addFlash('success', 'Le compte du client a été activé avec succès.');

        // Rediriger vers la liste des clients
        return $this->redirectToRoute('client_list');
    }

    #[Route('/clients/{id}/deactivate', name: 'client_deactivate')]
    public function deactivateClient(Client $client, EntityManagerInterface $entityManager): Response
    {
        // Désactiver le compte du client
        $client->setStatusCompte('inactive');
        $entityManager->flush();

        // Ajouter un message flash
        $this->addFlash('success', 'Le compte du client a été désactivé avec succès.');

        // Rediriger vers la liste des clients
        return $this->redirectToRoute('client_list');
    }
}
