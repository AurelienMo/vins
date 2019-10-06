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

namespace App\Entity\AdminMutators;

/**
 * Trait VineProfileTrait
 */
trait VineProfileTrait
{
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}
