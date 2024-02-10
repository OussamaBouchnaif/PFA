<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $manager;
    private UserPasswordHasherInterface $passwordEncoder;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager, UserPasswordHasherInterface $passwordEncoder)
    {
        parent::__construct($registry, Client::class);
        $this->manager =$manager;
        $this->passwordEncoder = $passwordEncoder;
        
    }
    public function authenticateClient($email, $password): bool
    {
        $client = $this->findOneBy(['email' => $email]);

        if (!$client) {
            return false;
        }

        return $this->passwordEncoder->isPasswordValid($client, $password);
    }
    public function addClient(Client $client)
    {
        $client->setPlainPassword($client->getPassword());
        $this->manager->persist($client);
        $this->manager->flush();
    }

//    /**
//     * @return Client[] Returns an array of Client objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }




//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
