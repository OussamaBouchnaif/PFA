<?php

namespace App\Controller;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use App\Entity\Camera;
use App\Forms\AvisType;
<<<<<<< HEAD
<<<<<<< HEAD
use App\Factory\Factory;
use App\Entity\AvisCamera;
=======
>>>>>>> 1a61a15 (maintain code)
=======
use App\Factory\Factory;
use App\Entity\AvisCamera;
>>>>>>> 5d2fc98 (maintain servcie api)
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\AvisCameraRepository;
=======
>>>>>>> de23d16 (data)
=======
use App\Entity\AvisCamera;
=======
>>>>>>> 8e6fee8 (fix conflit)
use App\Entity\Camera;
use App\Forms\AvisType;
use App\Factory\Factory;
use App\Entity\AvisCamera;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\AvisCameraRepository;
<<<<<<< HEAD
use Doctrine\ORM\EntityManagerInterface;
>>>>>>> fdc8b02 (add reviews to a specific camera)
=======
>>>>>>> deb3afb (maintain code)
use App\Service\Api\CallApiCameraService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use App\Service\Api\Exception\ObjectNotFoundException;
=======
>>>>>>> de23d16 (data)
=======
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
>>>>>>> fdc8b02 (add reviews to a specific camera)
=======
>>>>>>> deb3afb (maintain code)
=======
use App\Service\Api\Exception\ObjectNotFoundException;
>>>>>>> 8e6fee8 (fix conflit)
=======
use App\Service\Api\Exception\ObjectNotFoundException;
=======
>>>>>>> 1a61a15 (maintain code)
>>>>>>> 2302ad2 (maintain code)
=======
use App\Service\Api\Exception\ObjectNotFoundException;
=======
>>>>>>> 1a61a15 (maintain code)
=======
use App\Service\Api\Exception\ObjectNotFoundException;
>>>>>>> 5d2fc98 (maintain servcie api)
>>>>>>> ee1b117 (maintain servcie api)
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_details')]
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function index(Camera $camera,AvisCameraRepository $avisRepo,CallApiCameraService $callapi,Factory $factory,Request $request): Response
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> ce65794 (conflit data)
=======
>>>>>>> ee1b117 (maintain servcie api)
    
=======
        
>>>>>>> 9bb638e (conflit data)
=======
    
>>>>>>> 5d2fc98 (maintain servcie api)
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

    
=======
    public function index(int $id,CallApiCameraService $callapi): Response
=======
    public function index(int $id,AvisCameraRepository $avisRepo,CallApiCameraService $callapi,Factory $factory,Request $request): Response
>>>>>>> fdc8b02 (add reviews to a specific camera)
=======
    public function index(Camera $camera,AvisCameraRepository $avisRepo,CallApiCameraService $callapi,Factory $factory,Request $request): Response
>>>>>>> 6fe7d29 (maintain controller avis)
    {

=======
        
>>>>>>> 2cf0464 (conflit data)
=======
    
>>>>>>> 8e6fee8 (fix conflit)
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
<<<<<<< HEAD
        ]);
    }
<<<<<<< HEAD
>>>>>>> de23d16 (data)
=======
=======
        ]);    }
>>>>>>> 8e6fee8 (fix conflit)

    
>>>>>>> 6fe7d29 (maintain controller avis)
}
