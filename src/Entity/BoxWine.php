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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BoxWine
 *
 * @ORM\Table(name="amo_box_wine")
 * @ORM\Entity()
 */
class BoxWine extends AbstractEntity
{
    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @var Capacity[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Capacity")
     * @ORM\JoinTable(name="box_wine_has_capacities",
     *     joinColumns={@ORM\JoinColumn(name="box_wine_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="capacity_id", referencedColumnName="id")}
     *     )
     */
    protected $wines;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @return Capacity[]|Collection
     */
    public function getWines()
    {
        return $this->wines;
    }

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
    }

    public function addCapacity(Capacity $capacity)
    {
        $this->wines->add($capacity);
    }

    public function removeCapaciy(Capacity $capacity)
    {
        $this->wines->removeElement($capacity);
    }
}
