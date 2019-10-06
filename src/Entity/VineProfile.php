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

namespace App\Entity;

use App\Entity\AdminMutators\VineProfileTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class VineProfile
 *
 * @ORM\Table(name="mps_vine_profile")
 * @ORM\Entity()
 */
class VineProfile extends AbstractEntity
{
    use VineProfileTrait;
    use NameTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $color;

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }
}
