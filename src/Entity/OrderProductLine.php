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

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderProductLine
 *
 * @ORM\Table(name="amo_order_product_line")
 * @ORM\Entity(repositoryClass="App\Repository\OrderProductLineRepository")
 */
class OrderProductLine extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @var Order|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="lines")
     * @ORM\JoinColumn(name="amo_order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $amount;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $tvaRate;

    /**
     * @var Capacity|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Capacity")
     * @ORM\JoinColumn(name="amo_capacity_wine_id", referencedColumnName="id", nullable=true)
     */
    protected $capacityWine;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $wineName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $typeCapacity;

    /**
     * @var string|null
     */
    protected $quantityCapacity;

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order|null $order
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return float|null
     */
    public function getTvaRate(): ?float
    {
        return $this->tvaRate;
    }

    /**
     * @param float|null $tvaRate
     */
    public function setTvaRate(?float $tvaRate): void
    {
        $this->tvaRate = $tvaRate;
    }

    /**
     * @return Capacity|null
     */
    public function getCapacityWine(): ?Capacity
    {
        return $this->capacityWine;
    }

    /**
     * @param Capacity|null $capacityWine
     */
    public function setCapacityWine(?Capacity $capacityWine): void
    {
        $this->capacityWine = $capacityWine;
    }

    /**
     * @return string|null
     */
    public function getWineName(): ?string
    {
        return $this->wineName;
    }

    /**
     * @param string|null $wineName
     */
    public function setWineName(?string $wineName): void
    {
        $this->wineName = $wineName;
    }

    /**
     * @return string|null
     */
    public function getTypeCapacity(): ?string
    {
        return $this->typeCapacity;
    }

    /**
     * @param string|null $typeCapacity
     */
    public function setTypeCapacity(?string $typeCapacity): void
    {
        $this->typeCapacity = $typeCapacity;
    }

    /**
     * @return string|null
     */
    public function getQuantityCapacity(): ?string
    {
        return $this->quantityCapacity;
    }

    /**
     * @param string|null $quantityCapacity
     */
    public function setQuantityCapacity(?string $quantityCapacity): void
    {
        $this->quantityCapacity = $quantityCapacity;
    }
}
