<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function getTotalCommandes(): int
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->select('COUNT(c.id) as totalCommandes');

        $result = $queryBuilder->getQuery()->getSingleScalarResult();

        return (int) $result;
    }

    public function getCommandesParJour(): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('SUBSTRING(c.dateCommande, 1, 10) as dateCommande, COUNT(c.id) as count')
            ->groupBy('dateCommande')
            ->orderBy('dateCommande', 'ASC');

        $results = $queryBuilder->getQuery()->getResult();

        $commandesParJour = [
            'labels' => [],
            'data' => []
        ];

        foreach ($results as $result) {
            $commandesParJour['labels'][] = $result['dateCommande'];
            $commandesParJour['data'][] = $result['count'];
        }

        return $commandesParJour;
    }

    public function getRevenuMensuel(): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('YEAR(c.dateCommande) as year, MONTH(c.dateCommande) as month, SUM(c.total) as total')
            ->groupBy('year, month')
            ->orderBy('year', 'ASC')
            ->addOrderBy('month', 'ASC');

        $results = $queryBuilder->getQuery()->getResult();

        $revenuMensuel = [
            'labels' => [],
            'data' => []
        ];

        foreach ($results as $result) {
            $dateKey = $result['year'] . '-' . str_pad($result['month'], 2, '0', STR_PAD_LEFT);
            $revenuMensuel['labels'][] = $dateKey;
            $revenuMensuel['data'][] = (float) $result['total'];
        }

        return $revenuMensuel;
    }

    public function getProduitsLesPlusVendus(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT cam.nom, SUM(lc.qte) as count
             FROM App\Entity\LigneCommande lc
             JOIN lc.camera cam
             GROUP BY cam.id
             ORDER BY count DESC'
        )->setMaxResults(10);

        $results = $query->getResult();

        $produitsLesPlusVendus = [
            'labels' => [],
            'data' => []
        ];

        foreach ($results as $result) {
            $produitsLesPlusVendus['labels'][] = $result['nom'];
            $produitsLesPlusVendus['data'][] = $result['count'];
        }

        return $produitsLesPlusVendus;
    }

    public function countCommandesByStatus(): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c.status, COUNT(c) as count')
            ->groupBy('c.status');

        $results = $queryBuilder->getQuery()->getResult();

        $countByStatus = [
            'labels' => [],
            'data' => []
        ];

        foreach ($results as $result) {
            $countByStatus['labels'][] = $result['status'];
            $countByStatus['data'][] = $result['count'];
        }

        return $countByStatus;
    }

    public function getTotalRevenueByYear(int $year): float
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('SUM(c.total) as totalRevenue')
            ->where('YEAR(c.dateCommande) = :year')
            ->setParameter('year', $year);

        $result = $queryBuilder->getQuery()->getSingleScalarResult();

        return (float) $result;
    }

    public function getCommandesParAn(): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('YEAR(c.dateCommande) as year, COUNT(c.id) as count')
            ->groupBy('year')
            ->orderBy('year', 'ASC');

        $results = $queryBuilder->getQuery()->getResult();

        $commandesParAn = [
            'labels' => [],
            'data' => []
        ];

        foreach ($results as $result) {
            $commandesParAn['labels'][] = $result['year'];
            $commandesParAn['data'][] = $result['count'];
        }

        return $commandesParAn;
    }
    function countCommandeAnulees(): int
    {

        $queryBuilder = $this->createQueryBuilder('c')
            ->select('COUNT(c.id) as count')
            ->where('c.status = :status')
            ->setParameter('status', 'annulee')
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $queryBuilder;
    }
}
