<?php

namespace App\Controller;

use App\Entity\Camera;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\CameraRepository;
use App\Repository\CategorieRepository;
use App\Service\Api\CallApiCameraService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CameraController extends AbstractController
{
    #[Route('/camera',name:'app_camera')]
    public function delete(SessionInterface $session):Response
    {
        $session->remove('searchCriteria');
        return $this->redirectToRoute('camera_search');
    }

    #[Route('/camera/search', name: 'camera_search')]
    public function search(Request $request,CameraRepository $cameraRepository, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session,PaginatorInterface $paginatorInterface): Response
    {     
        $categorie = $catrepo->findAll();
        $searchCriteria = $session->get('searchCriteria', array());
        $newCriteria = [
            'resolution' => $request->query->get('res'),
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle'),
            'connectivite' => $request->query->get('connectivite'),
            'prix' => $request->query->get('price_range') ? implode('..', array_map(function($price) { return floatval(str_replace('$', '', $price)); }, explode(' - ', $request->query->get('price_range')))) : null,
        ];
    
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
        
        $session->set('searchCriteria', $searchCriteria);
        $cameras = $callApiCameraService->SearchBy($searchCriteria);
        $data = $cameraRepository->getPagination($cameras,$paginatorInterface,$request);
        
        if ($request->isXmlHttpRequest()) {
            return $this->render('client/pages/components/cameras.html.twig', [
                'cameras' => $data,
                'categories'=> $categorie,
            ]);
        }
        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $data,
            'categories'=> $categorie,
        ]);
    }
    
 
   

}
