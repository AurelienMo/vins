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
     * @var Product|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id")
     */
    protected $wine;

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
}
