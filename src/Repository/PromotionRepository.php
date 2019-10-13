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

use App\Entity\Promotion;

/**
 * Class PromotionRepository
 */
class PromotionRepository extends AbstractServiceRepository
{
    public function isOtherPromotionInProgressAsSamePeriod(Promotion $promotion, string $wineId)
    {
        $start = $promotion->getStartAt();
        $end = $promotion->getEndAt();
        $results = $this->createQueryBuilder('pr')
                   ->join('pr.product', 'p')
                   ->where('p.id = :wineId')
                   ->setParameters(
                       [
                           'wineId' => $wineId,
                       ]
                   )
                   ->getQuery()->getResult();

        foreach ($results as $result) {
            if ($start > $result->getStartAt() && $start < $result->getEndAt()) {
                return true;
            }
            if ($end > $result->getStartAt() && $end < $result->getEndAt()) {
                return true;
            }
        }

        return false;
    }

    protected function getClassEntityName(): string
    {
        return Promotion::class;
    }
}
