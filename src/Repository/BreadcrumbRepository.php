<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Breadcrumb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class BreadcrumbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breadcrumb::class);
    }

    public function findByPage(string $page)
    {
        return $this->createQueryBuilder('b')
                    ->where('b.page = :page')
                    ->setParameter('page', $page)
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getOneOrNullResult();
    }
}
