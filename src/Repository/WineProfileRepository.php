<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <aurelien.morvan@infostrates.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\VineProfile;
use Doctrine\Common\Persistence\ManagerRegistry;

final class WineProfileRepository extends AbstractServiceRepository
{
    public function findAllOrderedByOrder()
    {
        return $this->createQueryBuilder('wp')
                    ->orderBy('wp.order')
                    ->getQuery()
                    ->getResult();
    }

    protected function getClassEntityName(): string
    {
        return VineProfile::class;
    }
}
