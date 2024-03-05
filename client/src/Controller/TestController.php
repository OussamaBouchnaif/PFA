<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\CodePromo;
use Symfony\UX\Turbo\TurboBundle;
use App\Service\CallApiCameraService;
use Symfony\Component\Mercure\Update;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TestController extends AbstractController
{
    
 


    #[Route('/test',name:'test')]
    public function testss(Request $request):Response
    {
        $form = $this->createFormBuilder()
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

<<<<<<< HEAD
        return $this->render('client/pages/product-details.html.twig', [
=======
        return $this->render('test/index.html.twig', [
>>>>>>> 1dee0b6 (add filter by resolution and angle Vision)
            'form' => $form->createView(),
            // Correction: Utilisez `createView()` pour passer le formulaire à Twig.
        ]);
    
    }

    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('client/pages/index.html.twig');
    }
    
    #[Route('/shop', name: 'shop')]
    public function shop(): Response
    {
        return $this->render('client/pages/shop.html.twig');
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
