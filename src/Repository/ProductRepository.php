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

    public function findOnlyActive(array $queryParams)
    {
        $qb = $this->createQueryBuilder('p')
                    ->where('p.active = true');

        if (count($queryParams) > 0) {
            if (array_key_exists('p', $queryParams) && $queryParams['p'] !== '') {
                $profileParams = explode(',', $queryParams['p']);
                $qb->join('p.profile', 'pro');
                if (in_array('Les blancs', $profileParams)) {
                    $qb->join('p.typeProduct', 'type')
                        ->andWhere('type.name = :whitetypename')
                        ->setParameter('whitetypename', 'Les blancs');
                    unset($profileParams[array_search('Les blancs', $profileParams)]);
                }
                if (in_array('Les rosés', $profileParams)) {
                    $qb->join('p.typeProduct', 'type')
                        ->andWhere('type.name = :pinktypename')
                        ->setParameter('pinktypename', 'Les rosés');
                    unset($profileParams[array_search('Les rosés', $profileParams)]);
                }
                if (in_array('Les rouges', $profileParams)) {
                    $qb->join('p.typeProduct', 'type')
                        ->andWhere('type.name = :redtypename')
                        ->setParameter('redtypename', 'Les rouges');
                    unset($profileParams[array_search('Les rouges', $profileParams)]);
                }
                if (count($profileParams) > 0) {
                    $qb->andWhere('pro.name IN (:profils)')
                        ->setParameter('profils', array_values($profileParams));
                }
            }
            if (array_key_exists('r', $queryParams) && $queryParams['r'] !== '') {
                $regionParams = explode(',', $queryParams['r']);
                if (count($regionParams) > 0) {
                    $qb->andWhere('p.region IN (:regions)')
                        ->setParameter('regions', array_values($regionParams));
                }
            }
            if (array_key_exists('a', $queryParams) && $queryParams['a'] !== '') {
                $accordParams = explode(',', $queryParams['a']);
                if (count($accordParams) > 0) {
                    $qb->join('p.agreements', 'a')
                        ->andWhere('a.name IN (:aggrements)')
                        ->setParameter('aggrements', array_values($accordParams));
                }
            }
            if (array_key_exists('o', $queryParams) && $queryParams['o'] !== '') {
                $occasionsParams = explode(',', $queryParams['o']);
                if (count($occasionsParams) > 0) {
                    $qb->andWhere('p.wineService.opportunity IN (:occasions)')
                        ->setParameter('occasions', array_values($occasionsParams));
                }
            }
        }

        return $qb->getQuery()->getResult();
    }

    public function selectOccasions()
    {
        return $this->createQueryBuilder('p')
            ->select('p.wineService.opportunity')
            ->distinct()
            ->orderBy('p.wineService.opportunity')
            ->getQuery()
            ->getResult();
    }

    protected function getClassEntityName(): string
    {
        return Product::class;
    }
}
