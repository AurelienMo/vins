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

use App\Entity\Capacity;

/**
 * Class CapacityRepository
 */
final class CapacityRepository extends AbstractServiceRepository
{
    protected function getClassEntityName(): string
    {
        return Capacity::class;
    }
}
