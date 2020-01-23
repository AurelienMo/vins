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

namespace App\Domain\WineProfile;

use App\Repository\WineProfileRepository;

final class Resolver
{
    /** @var WineProfileRepository */
    protected $wineProfileRepo;

    /**
     * Resolver constructor.
     *
     * @param WineProfileRepository $wineProfileRepo
     */
    public function __construct(
        WineProfileRepository $wineProfileRepo
    ) {
        $this->wineProfileRepo = $wineProfileRepo;
    }

    public function getListWineProfiles()
    {
        return $this->wineProfileRepo->findAll();
    }


}
