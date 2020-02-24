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

use App\Entity\Product;

/**
 * Class ProductRepository
 */
class ProductRepository extends AbstractServiceRepository
{
    public function findPromote(int $limit = 4)
    {
        return $this->createQueryBuilder('p')
                    ->where('p.isPromote = true')
                    ->andWhere('p.active = true')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    public function findOnlyActive()
    {
        return $this->createQueryBuilder('p')
                    ->where('p.active = true')
                    ->getQuery()
                    ->getResult();
    }

    protected function getClassEntityName(): string
    {
        return Product::class;
    }
}
