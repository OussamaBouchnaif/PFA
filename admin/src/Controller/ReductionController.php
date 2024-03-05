<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\Reduction;
use App\Form\ReductionType;
use App\Repository\ReductionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
>>>>>>> 7b86827 (fixer supression avec photo)
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReductionController extends AbstractController
{
<<<<<<< HEAD
    private $entityManager;
    private $reductionRepository;

    public function __construct(EntityManagerInterface $entityManager, ReductionRepository $reductionRepository)
    {
        $this->entityManager = $entityManager;
        $this->reductionRepository = $reductionRepository;
    }

    #[Route('/reduction_add', name: 'reduction_add')]
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


    #[Route('/reductionedit/{id}', name: 'reduction_edit')]
    public function edit(Request $request, Reduction $reduction): Response
    {
        $form = $this->createForm(ReductionType::class, $reduction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('reduction_show', ['id' => $reduction->getId()]);
        }

        return $this->render('admin/reduction/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reductiondelete/{id}', name: 'reduction_delete')]
    public function delete(Request $request, Reduction $reduction): Response
    {
        $this->entityManager->remove($reduction);
        $this->entityManager->flush();

        return $this->redirectToRoute('reduction_show');
    }
=======
    #[Route('/reduction', name: 'app_reduction')]
    public function index(): Response
    {
        return $this->render('reduction/index.html.twig', [
            'controller_name' => 'ReductionController',
            
        ]);
    }
>>>>>>> 7b86827 (fixer supression avec photo)
}
