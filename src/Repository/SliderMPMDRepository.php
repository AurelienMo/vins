<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SliderMPMD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SliderMPMDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SliderMPMD::class);
    }
}
