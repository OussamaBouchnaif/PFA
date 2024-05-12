<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/', name: '')]
    public function test(Request $request, ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();

        return $this->render('admin/client/client_list.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/clients', name: 'client_list')]
    public function listClients(Request $request, ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();

        return $this->render('admin/client/client_list.html.twig', [
            'clients' => $clients,
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

    #[Route('/clients/update-account-status', name: 'update_account_status')]
    public function updateAccountStatus(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $clientId = $request->request->get('clientId');
        $accountStatus = $request->request->get('accountStatus');

        // Récupérer le client à partir de l'ID
        $client = $entityManager->getRepository(Client::class)->find($clientId);

        // Vérifier si le client existe
        if (!$client) {
            return new JsonResponse('error', JsonResponse::HTTP_NOT_FOUND);
        }

        // Basculer l'état du compte entre actif et inactif
        $newStatus = 'active' === $accountStatus ? 'inactive' : 'active';
        $client->setStatusCompte($newStatus);
        $entityManager->flush();

        return new JsonResponse('success', JsonResponse::HTTP_OK);
    }
}
