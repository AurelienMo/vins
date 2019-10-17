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
}
