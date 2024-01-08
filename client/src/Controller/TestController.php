<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\CodePromo;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\Mercure\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
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


    #[Route('/dash', name: 'ds')]
    public function dash(): Response
    {
        return $this->render('dashboard/admin/test.html.twig');
    }
    #[Route('/test', name: 'tst')]
    public function test(): Response
    {
        return $this->render('dashboard/admin/a.html.twig');
    }


    #[Route('/command',name:'user')]
    public function command(EntityManagerInterface $manager,CommandeRepository $repo):Response
    {
       
        $client = new Client();
        $client->setNom('NomClient');
        $client->setPrenom('PrenomClient');
        $client->setEmail('client@example.com');
        $client->setPassword('password123');
        $client->setAddress('123 Main Street');
        $client->setDateInscription(new \DateTime()); // Vous pouvez également utiliser $client->setDateInscription(new \DateTime('now'));
        $client->setStatusCompte('actif');
        $client->setVille('VilleClient');
        $client->setPtsFidelite(100);
        $client->setAddressLivSup('Address Livraison Supplémentaire');
    
        $code = new CodePromo();
        $code->setCode("sdf");
        $code->setDescription("qsc");
        $code->setPourcentage(5);
        $code->setDateExpiration(new \DateTime());
        $code->setNombreAutorisation(5);
        $code->setStatus("qsdqsd");

        $commande = new Commande();
        $commande->setDateCommande(new \DateTime()); // Vous pouvez également utiliser $commande->setDateCommande(new \DateTime('now'));
        $commande->setStatus('En cours');
        $commande->setTotal(140.50);
        
        // Lier le client à la commande
        $commande->setClient($client);
        $commande->setCodePromo($code);

        // Enregistrer le client
        $manager->persist($client);
        $manager->persist($code);
        $manager->persist($commande);
        $manager->flush();
    
        return new Response('id = ' . $client->getId());

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
