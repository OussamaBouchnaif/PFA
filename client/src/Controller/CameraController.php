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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function search(Request $request,CameraRepository $cameraRepository, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session): Response
    {     
        $page = $request->query->getInt('page',1);        
        $categorie = $catrepo->findAll();
<<<<<<< HEAD
=======
    public function search(Request $request, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session,PaginatorInterface $paginatorInterface): Response
    {
        
        $searchCriteria = $session->get('searchCriteria', array());

>>>>>>> 289cd85 (search by categories)
        $newCriteria = [
            'order' => $request->query->get('orderby'),
=======
    public function search(Request $request,CameraRepository $cameraRepository, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session,PaginatorInterface $paginatorInterface): Response
=======
    public function search(Request $request,CameraRepository $cameraRepository, CallApiCameraService $callApiCameraService, CategorieRepository $catrepo, SessionInterface $session): Response
>>>>>>> 44d6728 (adapt api's pagination)
    {     
        $page = $request->query->getInt('page',1);        
        $categorie = $catrepo->findAll();
        $searchCriteria = $session->get('searchCriteria', array());
        $newCriteria = [
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
=======
        $newCriteria = [
            'order' => $request->query->get('orderby'),
>>>>>>> fa04ec1 (maintain search code)
            'resolution' => $request->query->get('res'),
            'categorie.nom' => $request->query->get('categorie'),
            'angleVision' => $request->query->get('angle'),
            'prix' => $request->query->get('price_range') ? implode('..', array_map(function($price) { return floatval(str_replace('$', '', $price)); }, explode(' - ', $request->query->get('price_range')))) : null,
        ];
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD

        $searchCriteria = $cameraRepository->fillInTheSession($newCriteria,$session);
        $session->set('searchCriteria', $searchCriteria);
        
        $cameras = $callApiCameraService->SearchBy($searchCriteria,$page,9);
        $pagination = $cameraRepository->extractPaginationInfo($page);
        if ($request->isXmlHttpRequest()) {
           
            return $this->render('client/pages/components/cameras.html.twig', [
                'cameras' => $cameras,
                'categories'=> $categorie,
                'pagination' => $pagination,
                'items'=>$callApiCameraService->getItems(),
            ]);
        }
        return $this->render('client/pages/shop.html.twig',[
            'cameras' => $cameras,
=======
    
=======
>>>>>>> 44d6728 (adapt api's pagination)
        foreach ($newCriteria as $key => $value) {
            if (!empty($value)) {
                $searchCriteria[$key] = $value; 
            }
        }
        
=======

        $searchCriteria = $cameraRepository->fillInTheSession($newCriteria,$session);
>>>>>>> fa04ec1 (maintain search code)
        $session->set('searchCriteria', $searchCriteria);
        $cameras = $callApiCameraService->SearchBy($searchCriteria,$page,9);
        $pagination = $cameraRepository->extractPaginationInfo($page);
        if ($request->isXmlHttpRequest()) {
            
            return $this->render('client/pages/components/cameras.html.twig', [
                'cameras' => $cameras,
                'categories'=> $categorie,
                'pagination' => $pagination,
                'items'=>$callApiCameraService->getItems(),
            ]);
        }
        return $this->render('client/pages/shop.html.twig',[
<<<<<<< HEAD
            'cameras' => $data,
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
            'categories'=> $categorie,
            'pagination' => $pagination,
            'items'=>$callApiCameraService->getItems(),
        ]);
    }
<<<<<<< HEAD
=======
            'cameras' => $cameras,
            'categories'=> $categorie,
            'pagination' => $pagination,
            'items'=>$callApiCameraService->getItems(),
        ]);
    }
>>>>>>> 44d6728 (adapt api's pagination)

  
    
    
 
=======
    
<<<<<<< HEAD
    #[Route('/cat',name:'categorie')]
    public function dd(Request $request):Response
    {
        dd($request->query->get('categorie'));
    }

>>>>>>> 289cd85 (search by categories)
=======
 
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
   

}
