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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Stock
 *
 * @ORM\Table(name="amo_stock")
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity = 0;

    /**
     * @var Product
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Product", inversedBy="stock")
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id")
     */
    protected $wine;

    /**
     * @var StockEntry[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\StockEntry", mappedBy="stock", cascade={"persist", "remove"})
     */
    protected $stockEntries;

    public function __construct()
    {
        $this->stockEntries = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Product
     */
    public function getWine(): Product
    {
        return $this->wine;
    }

    /**
     * @param Product $wine
     */
    public function setWine(Product $wine): void
    {
        $this->wine = $wine;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function updateQuantity(StockEntry $entry): void
    {
        $this->quantity += $entry->getQuantity();
    }

    public function __toString()
    {
        return sprintf('%s', $this->wine);
    }

    /**
     * @return StockEntry[]|Collection
     */
    public function getStockEntries()
    {
        return $this->stockEntries;
    }

    public function addStockEntry(StockEntry $entry)
    {
        $this->stockEntries->add($entry);
        $entry->setStock($this);
        $this->updateQuantity($entry);

        return $this;
    }

    public function removeStockEntry(StockEntry $entry)
    {
        $this->updateQuantity($entry);
        $this->stockEntries->removeElement($entry);
    }
}
