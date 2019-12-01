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
     * @var string|null
     *
     * @ORM\Column(type="string", length=190)
     */
    protected $decanting;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text")
     */
    protected $meat;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text")
     */
    protected $cheese;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text")
     */
    protected $fish;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text")
     */
    protected $vegetable;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text")
     */
    protected $dessert;

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
     * @return string|null
     */
    public function getDecanting(): ?string
    {
        return $this->decanting;
    }

    /**
     * @param string|null $decanting
     */
    public function setDecanting(?string $decanting): void
    {
        $this->decanting = $decanting;
    }

    /**
     * @return string|null
     */
    public function getMeat(): ?string
    {
        return $this->meat;
    }

    /**
     * @param string|null $meat
     */
    public function setMeat(?string $meat): void
    {
        $this->meat = $meat;
    }

    /**
     * @return string|null
     */
    public function getCheese(): ?string
    {
        return $this->cheese;
    }

    /**
     * @param string|null $cheese
     */
    public function setCheese(?string $cheese): void
    {
        $this->cheese = $cheese;
    }

    /**
     * @return string|null
     */
    public function getFish(): ?string
    {
        return $this->fish;
    }

    /**
     * @param string|null $fish
     */
    public function setFish(?string $fish): void
    {
        $this->fish = $fish;
    }

    /**
     * @return string|null
     */
    public function getVegetable(): ?string
    {
        return $this->vegetable;
    }

    /**
     * @param string|null $vegetable
     */
    public function setVegetable(?string $vegetable): void
    {
        $this->vegetable = $vegetable;
    }

    /**
     * @return string|null
     */
    public function getDessert(): ?string
    {
        return $this->dessert;
    }

    /**
     * @param string|null $dessert
     */
    public function setDessert(?string $dessert): void
    {
        $this->dessert = $dessert;
    }
}
