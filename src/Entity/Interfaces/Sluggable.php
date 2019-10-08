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

namespace App\Entity\Interfaces;

/**
 * Interface Sluggable
 */
interface Sluggable
{
    public function getSlug(): ?string;

    public function setSlug(?string $text): void;
}
