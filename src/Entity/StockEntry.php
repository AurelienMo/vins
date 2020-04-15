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

use App\Admin\Traits\ValueListTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StockEntry
 *
 * @ORM\Table(name="amo_stock_entry")
 * @ORM\Entity(repositoryClass="App\Repository\StockEntryRepository")
 */
class StockEntry extends AbstractEntity
{
    use ValueListTrait;

    public const TYPE_IN = 'entree';
    public const TYPE_OUT = 'sortie';
    public const LIST_TYPE = [
        'Entrée' => 'entree',
        'Sortie' => 'sortie'
    ];

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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $typeEntry;

    /**
     * @var Order|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     */
    protected $order;

    public static function create(Stock $stock, int $quantity, Order $order = null)
    {
        $stockEntry = new StockEntry();
        $stockEntry->setQuantity($quantity);
        $stockEntry->setStock($stock);
        $stockEntry->setTypeEntry(self::TYPE_OUT);

        if ($order instanceof Order) {
            $stockEntry->setOrder($order);
        }

        return $stockEntry;
    }

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

    public function getTypeEntry()
    {
        return $this->typeEntry;
    }

    public function setTypeEntry(string $typeEntry): void
    {
        $this->typeEntry = $typeEntry;
    }

    public function getTypeWine()
    {
        return $this->getWine()->getTypeProduct()->getName();
    }

    private function getWine()
    {
        return $this->stock->getCapacity()->getWine();
    }

    public function getWineName()
    {
        return sprintf(
            '%s - %s',
            $this->getWine()->getAppellation(),
            $this->getWine()->getVintageName()
        );
    }

    public function getCapacityName()
    {
        return $this->stock->getCapacity()->getCapacityFullname(). 'L';
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }
}
