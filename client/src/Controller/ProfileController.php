<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Forms\TrackOrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private Security $security
    ) {
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        $orders = $this->manager->getRepository(Cart::class)->findBy(
            ['Client' => $user],
            ['createdAt' => 'DESC']
        );

        $lastThreeOrders = array_slice($orders, 0, 2);
        return $this->render('client/pages/profile/profile.html.twig', [
            'orders' => $lastThreeOrders,
            'customer' => $this->security->getUser(),
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
        $user = $this->security->getUser();
        $orders = $this->manager->getRepository(Cart::class)->findBy(
            ['Client' => $user],
        );

        return $this->render('client/pages/profile/orders.html.twig', [
            'customer' => $this->security->getUser(),
            'orders'=>$orders,
        ]);
    }
}
