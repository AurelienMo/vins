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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class StockEntry
 *
 * @ORM\Table(name="amo_stock_entry")
 * @ORM\Entity()
 */
class StockEntry extends AbstractEntity
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @var Stock
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="stockEntries")
     * @ORM\JoinColumn(name="amo_stock_id", referencedColumnName="id")
     */
    protected $stock;

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
     * @return Stock
     */
    public function getStock(): Stock
    {
        return $this->stock;
    }

    /**
     * @param Stock $stock
     */
    public function setStock(Stock $stock): void
    {
        $this->stock = $stock;
    }
}
