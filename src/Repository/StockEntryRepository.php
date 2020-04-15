<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\StockEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class StockEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockEntry::class);
    }

    public function findByIds(array $listIds)
    {
        return $this->createQueryBuilder('se')
                    ->select('se.id')
                    ->addSelect('se.quantity')
                    ->where('se.id IN (:ids)')
                    ->setParameter('ids', array_values($listIds))
                    ->getQuery()
                    ->getResult();
    }
}
