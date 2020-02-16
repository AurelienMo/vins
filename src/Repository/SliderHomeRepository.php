<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SliderHome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SliderHomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SliderHome::class);
    }

    public function selectHighestOrderNumber()
    {
        return $this->createQueryBuilder('sh')
                    ->select('sh.order')
                    ->orderBy('sh.order', 'DESC')
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
