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

use App\Entity\BoxWine;

class BoxWineRepository extends AbstractServiceRepository
{
    public function listAllActiveWithStock()
    {
        return $this->createQueryBuilder('bw')
            ->join('bw.wines', 'c')
            ->join('c.stock', 's')
            ->where('bw.isActive = true')
            ->andWhere('s.quantity > 0')
            ->getQuery()
            ->getResult();
    }

    protected function getClassEntityName(): string
    {
        return BoxWine::class;
    }

    public function listAllBoxWinesExceptOne(string $id)
    {
        return $this->createQueryBuilder('bw')
                    ->where('bw.id != :id')
                    ->andWhere('bw.isActive = true')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult();
    }
}
