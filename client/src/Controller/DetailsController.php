<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Forms\AvisType;
<<<<<<< HEAD
use App\Factory\Factory;
use App\Entity\AvisCamera;
=======
>>>>>>> 1a61a15 (maintain code)
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\AvisCameraRepository;
use App\Service\Api\CallApiCameraService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
<<<<<<< HEAD
use App\Service\Api\Exception\ObjectNotFoundException;
=======
>>>>>>> 1a61a15 (maintain code)
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_details')]
    public function index(Camera $camera,AvisCameraRepository $avisRepo,CallApiCameraService $callapi,Factory $factory,Request $request): Response
    {
<<<<<<< HEAD
    
=======
        
>>>>>>> 9bb638e (conflit data)
        $avisCamera = $factory->create(AvisCamera::class);
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
            'comments' => $comments
        ]);    }

    
}
