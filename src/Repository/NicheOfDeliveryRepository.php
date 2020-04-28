<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\NicheOfDelivery;
use Doctrine\ORM\EntityRepository;

/**
 * Class NicheOfDeliveryRepository
 */
class NicheOfDeliveryRepository extends AbstractServiceRepository
{
    protected function getClassEntityName(): string
    {
        return NicheOfDelivery::class;
    }

    public static function listFreeNiche(NicheOfDeliveryRepository $r)
    {
        return $r->createQueryBuilder('nod')
                 ->where('nod.numberNiche > 0')
                 ->orderBy('nod.dateNiche', 'ASC');
    }

    public static function listAvailableNiche(EntityRepository $repo)
    {
        return $repo->createQueryBuilder('nod')
            ->where('nod.numberNiche > 0 AND nod.dateNiche >= :date')
            ->setParameter('date', new \DateTime('-12 hours'))
            ->orderBy('nod.dateNiche', 'ASC');
//            ->addOrderBy('nod.startAt', 'ASC');
    }
}
