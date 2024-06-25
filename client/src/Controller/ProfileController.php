<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Forms\EditProfileType;
use App\Forms\TrackOrderType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();
        $orders = $this->manager->getRepository(Cart::class)->findBy(
            ['Client' => $user],
            ['createdAt' => 'DESC']
        );

        $lastThreeOrders = array_slice($orders, 0, 2);
        return $this->render('client/pages/profile/profile.html.twig', [
            'orders' => $lastThreeOrders,
            'customer' => $this->getUser(),
            'orderCount' => $orders,
        ]);
    }

    #[Route('/track', name: 'track_order')]
    public function fetchOrder(Request $request): Response
    {
        $form = $this->createForm(TrackOrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $orderCode = $data['code'];

            $order = $this->manager->getRepository(Cart::class)->findOneBy(['code' => $orderCode]);

            if ($order) {
                $response = [
                    'status' => $order->getStatus(),
                    'message' => 'Order found',
                    'createdAt' => $order->getCreatedAt()->format('Y-m-d H:i:s')
                ];
            } else {
                $response = [
                    'status' => 'not found',
                    'message' => 'Order not found',
                ];
            }

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse($response);
            } else {
                return $this->render('client/pages/profile/track.html.twig', [
                    'form' => $form->createView(),
                    'orderStatus' => $response,
                ]);
            }
        }

        return $this->render('client/pages/profile/track.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    #[Route('/orders', name: 'app_orders')]
    public function orders(): Response
    {
        $user = $this->getUser();
        $orders = $this->manager->getRepository(Cart::class)->findBy(
            ['Client' => $user],
        );

        return $this->render('client/pages/profile/orders.html.twig', [
            'customer' => $this->getUser(),
            'orders'=>$orders,
        ]);
    }

    #[Route('/Edit_Profil',name:'edit_profil')]
    public function editProfile(Request $request ,ClientRepository $clientRepository):Response
    {
        $client = $this->getUser();
        $form = $this->createForm(EditProfileType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $client = $form->getData();
            $clientRepository->updateClient($client);
            $this->addFlash(
                'success',
                'le client a ete bien Modifier'
            );
            
        }
        return $this->render('client/pages/profile/edit_profile.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
