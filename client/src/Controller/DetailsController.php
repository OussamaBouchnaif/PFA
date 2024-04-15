<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Forms\AvisType;
use App\Entity\AvisCamera;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\AvisCameraRepository;
use App\Cart\Handler\CartStorageInterface;
use App\Service\Api\Cameras\getAllCameras;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsController extends AbstractController
{
    private CartStorageInterface $cartStorage;

    public function __construct(CartStorageInterface $cartStorage)
    {
        $this->cartStorage = $cartStorage;
    }
    
    #[Route('/details/{id}', name: 'app_details')]
    public function index(Camera $camera,AvisCameraRepository $avisRepo,
    getAllCameras $callapi,Request $request): Response
    {
        $avisCamera = new AvisCamera();
        $form = $this->createForm(AvisType::class);
        $form->handleRequest($request);
        $comments = $camera->getAvisCameras();
        if ($form->isSubmitted() && $form->isValid()) {
            
            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {  
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT); 
                $content = $form->getData()['content']; 
                $avisRepo->addAvisCamera($avisCamera,$content,$camera,$this->getUser());
                return $this->render('client/pages/components/avis.stream.html.twig', ['content' => $form->getData()['content'],'name'=>$this->getUser()->getNom(),'createdAt' => new \DateTimeImmutable()]); // Pass just the content string
            }
        }
        return $this->render('client/pages/product-details.html.twig', [
            'camera' => $callapi->getCameraById($camera->getId()),
            'form' => $form->createView(),
            'comments' => $comments,
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);    
    }

    
}
