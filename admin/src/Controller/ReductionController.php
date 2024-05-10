<?php

namespace App\Controller;

use App\Entity\LigneReduction;
use App\Entity\Reduction;
use App\Form\LigneReductionTypeForm;
use App\Form\ReductionType;
use App\Repository\ReductionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReductionController extends AbstractController
{
    private $entityManager;
    private $reductionRepository;

    public function __construct(EntityManagerInterface $entityManager, ReductionRepository $reductionRepository)
    {
        $this->entityManager = $entityManager;
        $this->reductionRepository = $reductionRepository;
    }

    #[Route('/reduction/reduction_add', name: 'reduction_add')]
    public function add(Request $request): Response
    {
        $reduction = new Reduction();
        $form = $this->createForm(ReductionType::class, $reduction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($reduction);
            $this->entityManager->flush();

            return $this->redirectToRoute('reduction_show', ['id' => $reduction->getId()]);
        }

        return $this->render('admin/reduction/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/reduction', name: 'reduction_show')]
    public function show(): Response
    {
        $reductions = $this->reductionRepository->findAll();

        return $this->render('admin/reduction/show.html.twig', [
            'reductions' => $reductions,
        ]);
    }

    #[Route('reduction/reductionedit/{id}', name: 'reduction_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Reduction $reduction): Response
    {
        $form = $this->createForm(ReductionType::class, $reduction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La réduction a été modifiée avec succès.');

            return $this->redirectToRoute('reduction_show', ['id' => $reduction->getId()]);
        }

        return $this->render('admin/reduction/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('reduction/reductiondelete/{id}', name: 'reduction_delete')]
    public function deleteReduction(EntityManagerInterface $entityManager, ReductionRepository $reductionRepository, $id): JsonResponse
    {
        // Find the reduction by ID
        $reduction = $reductionRepository->find($id);

        // If reduction is not found, return a JSON response with an error message
        if (!$reduction) {
            return new JsonResponse(['success' => false, 'message' => 'Reduction not found'], Response::HTTP_NOT_FOUND);
        }

        // Delete all associated ligne reductions
        foreach ($reduction->getLigneReductions() as $ligneReduction) {
            $entityManager->remove($ligneReduction);
        }

        // Remove the reduction itself
        $entityManager->remove($reduction);

        // Flush changes to the database
        $entityManager->flush();

        // Return a JSON response indicating success
        return new JsonResponse(['success' => true, 'message' => 'Reduction deleted successfully']);
    }
    #[Route('reduction/LigneReduction', name: 'LigneReduction')]
    public function addLigneReduction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneReduction = new LigneReduction();
        $form = $this->createForm(LigneReductionTypeForm::class, $ligneReduction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer la ligne de réduction dans la base de données
            $ligneReduction = $form->getData();
            $entityManager->persist($ligneReduction);
            $entityManager->flush();

            // Redirection vers une autre page ou affichage d'un message de succès
            $this->addFlash('success', 'La ligne de réduction a été ajoutée avec succès.');

            return $this->redirectToRoute('reduction_show');
        }

        return $this->render('admin/reduction/AddLigneReduction.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
