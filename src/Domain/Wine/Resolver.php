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

namespace App\Domain\Wine;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;

/**
 * Class Resolver
 */
final class Resolver
{
    /** @var ProductRepository */
    protected $wineRepo;

    /**
     * Resolver constructor.
     *
     * @param ProductRepository $wineRepo
     */
    public function __construct(
        ProductRepository $wineRepo
    ) {
        $this->wineRepo = $wineRepo;
    }

    public function findPromote(): array
    {
        return $this->wineRepo->findPromote();
    }

    public function findAllProducts(): array
    {
        return $this->wineRepo->findAll();
    }
}
