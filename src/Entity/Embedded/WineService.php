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
 * Class WineService
 *
 * @ORM\Embeddable()
 */
class WineService
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $temp;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean")
     */
    protected $decanting;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $opportunity;

    /**
     * @var array|null
     *
     * @ORM\Column(type="array")
     */
    protected $grape;

    /**
     * @return int|null
     */
    public function getTemp(): ?int
    {
        return $this->temp;
    }

    /**
     * @param int|null $temp
     */
    public function setTemp(?int $temp): void
    {
        $this->temp = $temp;
    }

    /**
     * @return bool|null
     */
    public function getDecanting(): ?bool
    {
        return $this->decanting;
    }

    /**
     * @param bool|null $decanting
     */
    public function setDecanting(?bool $decanting): void
    {
        $this->decanting = $decanting;
    }

    /**
     * @return string|null
     */
    public function getOpportunity(): ?string
    {
        return $this->opportunity;
    }

    /**
     * @param string|null $opportunity
     */
    public function setOpportunity(?string $opportunity): void
    {
        $this->opportunity = $opportunity;
    }

    /**
     * @return array|null
     */
    public function getGrape(): ?array
    {
        return $this->grape;
    }

    /**
     * @param array|null $grape
     */
    public function setGrape(?array $grape): void
    {
        $this->grape = $grape;
    }
}
