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

use App\Entity\OrderProductLine;
use App\Entity\Promotion;

/**
 * Class OrderProductLineRepository
 */
class OrderProductLineRepository extends AbstractServiceRepository
{
    protected function getClassEntityName(): string
    {
        return OrderProductLine::class;
    }

    public function countOrderWithProductAndPromotionEnabled(Promotion $promotion)
    {
        $qb = $this->createQueryBuilder('opl')
                   ->join('opl.wine', 'w')
                   ->join('opl.order', 'o')
                   ->join('w.promotions', 'p')
                   ->where('p.id = :id')
                   ->andWhere('o.status = :status')
                   ->setParameters(
                       [
                           'status' => 'terminated',
                           'id' => $promotion->getId(),
                       ]
                   );

        $cpt = 0;

        /** @var OrderProductLine $line */
        foreach ($qb->getQuery()->getResult() as $line) {
            $cpt += $line->getQuantity();
        }

        return $cpt;
    }
}
