<?php

namespace App\Controller;

use App\Cart\Handler\CartStorageInterface;
use App\Entity\Camera;
use App\Reduction\Manager\ReductionInterface;
use App\Reduction\Manager\Strategy\AbstractReductionStrategy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

class TestController extends AbstractController
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private EntityManagerInterface $manager,
        private AbstractReductionStrategy $strategy,
        private ReductionInterface $redumanager,
    ) {
    }

    #[Route('/test', name: 'test')]
    public function testss(Request $request): Response
    {
        /* $form = $this->createFormBuilder()
            ->add('content', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Utilisez `isValid()` en plus de `isSubmitted()` pour vous assurer que les données du formulaire sont valides.

            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                // If the request comes from Turbo, set the content type as text/vnd.turbo-stream.html and only send the HTML to update
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                return $this->render('test/success.stream.html.twig', ['message' => $form->getData()]);
            }

        }

        return $this->render('client/pages/product-details.html.twig', [
            'form' => $form->createView(),
            // Correction: Utilisez `createView()` pour passer le formulaire à Twig.
        ]); */

        $camera = $this->manager->getRepository(Camera::class)->find(65);
        $reduction = $this->strategy->loadReduction($camera);
        $reduc = $this->strategy->getReductionModel($camera);

        $teste = $this->redumanager->getDiscountedCamera($camera, $reduc);

        dd($teste);
    }

    #[Route('/pay', name: 'shop')]
    public function shop(): Response
    {
        return $this->render('client/pages/pay.html.twig', [
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ]);
    }

    #[Route('/product', name: 'product')]
    public function product(): Response
    {
        return $this->render('client/pages/product-details.html.twig');
    }

    #[Route('/check', name: 'check')]
    public function check(): Response
    {
        return $this->render('client/pages/checkout.html.twig');
    }

    #[Route('/cart', name: 'cart')]
    public function cart(): Response
    {
        return $this->render('client/pages/cart.html.twig');
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('client/pages/blog.html.twig');
    }

    #[Route('/d', name: 'blogd')]
    public function blogdd(): Response
    {
        return $this->render('client/pages/blog_details.html.twig');
    }

    #[Route('/pub', name: 'appt')]
    public function publish(HubInterface $hub): Response
    {
        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'OutOfStock'])
        );

        $hub->publish($update);

        return new Response('published!');
    }
}
