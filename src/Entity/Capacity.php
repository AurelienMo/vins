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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Capacity
 *
 * @ORM\Table(name="amo_capacity")
 * @ORM\Entity(repositoryClass="App\Repository\CapacityRepository")
 */
class Capacity extends AbstractEntity
{
    const LIST_CAPACITIES = [
        'Bouteille' => 'Bouteille',
        'Cubis' => 'Cubis',
    ];

    /**
     * @var Product|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="capacities")
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $wine;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $quantity;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $unitPrice;

    /**
     * @return Product|null
     */
    public function getWine(): ?Product
    {
        return $this->wine;
    }

    /**
     * @param Product|null $wine
     */
    public function setWine(?Product $wine): void
    {
        $this->wine = $wine;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @param string|null $quantity
     */
    public function setQuantity(?string $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float|null
     */
    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    /**
     * @param float|null $unitPrice
     */
    public function setUnitPrice(?float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }
}
