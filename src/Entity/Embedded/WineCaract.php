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

namespace App\Entity\Embedded;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class WineCaract
 *
 * @ORM\Embeddable()
 */
class WineCaract
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $powerful;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $complex;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $spice;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $fruity;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $wooded;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $tannic;

    /**
     * @return int|null
     */
    public function getPowerful(): ?int
    {
        return $this->powerful;
    }

    /**
     * @param int|null $powerful
     */
    public function setPowerful(?int $powerful): void
    {
        $this->powerful = $powerful;
    }

    /**
     * @return int|null
     */
    public function getComplex(): ?int
    {
        return $this->complex;
    }

    /**
     * @param int|null $complex
     */
    public function setComplex(?int $complex): void
    {
        $this->complex = $complex;
    }

    /**
     * @return int|null
     */
    public function getSpice(): ?int
    {
        return $this->spice;
    }

    /**
     * @param int|null $spice
     */
    public function setSpice(?int $spice): void
    {
        $this->spice = $spice;
    }

    /**
     * @return int|null
     */
    public function getFruity(): ?int
    {
        return $this->fruity;
    }

    /**
     * @param int|null $fruity
     */
    public function setFruity(?int $fruity): void
    {
        $this->fruity = $fruity;
    }

    /**
     * @return int|null
     */
    public function getWooded(): ?int
    {
        return $this->wooded;
    }

    /**
     * @param int|null $wooded
     */
    public function setWooded(?int $wooded): void
    {
        $this->wooded = $wooded;
    }

    /**
     * @return int|null
     */
    public function getTannic(): ?int
    {
        return $this->tannic;
    }

    /**
     * @param int|null $tannic
     */
    public function setTannic(?int $tannic): void
    {
        $this->tannic = $tannic;
    }
}
