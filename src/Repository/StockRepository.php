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

use App\Entity\Stock;

/**
 * Class StockRepository
 */
class StockRepository extends AbstractServiceRepository
{
    protected function getClassEntityName(): string
    {
        return Stock::class;
    }

    public function findStockByParams(
        string $year,
        string $appellation,
        string $vintageName,
        string $domainName,
        string $capacityType,
        string $capacityQuantity
    ): Stock {
        return $this->createQueryBuilder('s')
                   ->join('s.capacity', 'c')
                   ->join('c.wine', 'w')
                   ->join('w.domain', 'd')
                   ->where('w.year = :year')
                   ->andWhere('w.appellation = :appellation')
                   ->andWhere('w.vintageName = :vintageName')
                   ->andWhere('d.name = :domainName')
                   ->andWhere('c.type = :capacityType')
                   ->andWhere('c.quantity = :capacityQuantity')
                   ->setParameters(
                       [
                           'year' => $year,
                           'appellation' => $appellation,
                           'vintageName' => $vintageName,
                           'domainName' => $domainName,
                           'capacityType' => $capacityType,
                           'capacityQuantity' => $capacityQuantity
                       ]
                   )
                   ->getQuery()
                   ->getSingleResult();
    }
}
