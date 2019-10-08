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

namespace App\Domain\Common\Helpers;

use Ramsey\Uuid\Uuid;

/**
 * Class UuidGenerator
 */
final class UuidGenerator
{
    public static function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
