<?php

namespace App\Controller;

use App\Cart\Handler\CartStorageInterface;
use App\Entity\Camera;
use App\Entity\FavoritCamera;
use App\Service\Api\Cameras\CameraFetcherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WishListController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private CameraFetcherInterface $fetcher,
        private EntityManagerInterface $manager,
        private Security $security,
        private RequestStack $stack,
    ) {
    }

    #[Route('/wish/list', name: 'app_wish_list')]
    public function index(Request $request): Response
    {
        $requestt = $this->stack->getCurrentRequest();
        if (!$this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $request->getSession()->set('referer',$requestt->getUri());
            return $this->redirectToRoute('app_login');
        }

        $wishList = $this->manager->getRepository(FavoritCamera::class)->wishList($this->security->getUser());

        return $this->render('client/pages/wish_list/index.html.twig', [
            'controller_name' => 'WishListController',
            'wishList' => $wishList,
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function addWishList(Camera $camera): Response
    {
        if (!$this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse(['success' => false, 'message' => 'Authentication required'], 401);
        }

        $favorit = $this->manager->getRepository(FavoritCamera::class)->findOneBy(['camera' => $camera, 'client' => $this->security->getUser()]);
        if (null === $favorit) {
            $this->manager->getRepository(FavoritCamera::class)->addToWishlist($camera, $this->security->getUser());

            return new JsonResponse(['success' => true, 'message' => 'success required'], 200);
        }

        return new JsonResponse(['success' => false, 'message' => 'Product already in wishlist'], 409);
    }

    #[Route('/delete/wishCamera/{id}', name: 'delete_favorit')]
    public function deleteWishCamera(FavoritCamera $favoritCamera): Response
    {
        $this->manager->remove($favoritCamera);
        $this->manager->flush();
        $wishlist = $this->manager->getRepository(FavoritCamera::class)->wishList($this->security->getUser());

        return $this->render('client/pages/components/wishlist_table.html.twig', [
            'wishList' => $wishlist,
        ]);
    }
}
