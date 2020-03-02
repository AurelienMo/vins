<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GlobalConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GlobalConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GlobalConfiguration::class);
    }

    public function findLatest()
    {
        return $this->createQueryBuilder('gc')
                    ->orderBy('gc.updatedAt', 'DESC')
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getOneOrNullResult();
    }
}
