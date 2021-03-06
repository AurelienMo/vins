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

use App\Entity\Order;
use App\Entity\Promotion;

/**
 * Class OrderRepository
 */
class OrderRepository extends AbstractServiceRepository
{
    public function findLastBillNumberForOrderYear(\DateTime $currentDate)
    {
        $currentYear = $currentDate->format('Y');
        return $this->createQueryBuilder('o')
             ->where('o.createdAt > :start AND o.createdAt < :endAt')
            ->setParameters(
                [
                    'start' => (int) $currentYear - 1 . '-12-31',
                    'endAt' => (int) $currentYear + 1 . '-01-01',
                ]
            )
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    protected function getClassEntityName(): string
    {
        return Order::class;
    }
}
