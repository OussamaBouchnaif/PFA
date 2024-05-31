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
    

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
           
    }
   
    public function addClient(Client $client)
    {
        $client->setPlainPassword($client->getPassword());
        $client->setRoles(['ROLE_USER']);
        $this->doSave($client,true);
    }

    public function updateClient(Client $client)
    {
        $this->doSave($client);
    }
    private function doSave($object,bool $isPersist = false):void
    {
        $manager = $this->getEntityManager();
        if(true === $isPersist)
        {
            $manager->persist($object);
        }
        $manager->flush();
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
