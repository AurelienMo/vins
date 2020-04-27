<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WineAgreement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

class WineAgreementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WineAgreement::class);
    }

    public function getAgreementOrderedByOrder()
    {
        return $this->createQueryBuilder('wa')
            ->orderBy('wa.order')
            ->getQuery()
            ->getResult();
    }

    public static function getOrderAgreement(EntityRepository $repo)
    {
        return $repo->createQueryBuilder('wa')
            ->orderBy('wa.order');
    }
}
