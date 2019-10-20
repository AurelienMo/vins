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
    use ValueListTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity = 0;

    /**
     * @var Product
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Product", inversedBy="stock", cascade={"remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $wine;

    /**
     * @var StockEntry[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\StockEntry", mappedBy="stock", cascade={"persist", "remove"}, orphanRemoval=true)
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

    public function updateQuantity(StockEntry $entry, string $type): void
    {
        switch ($type) {
            case 'add':
                $this->quantity += $entry->getQuantity();
                break;
            case 'remove':
                $this->quantity -= $entry->getQuantity();
                break;
        }
    }

    public function updateQuantityAfterOrder(int $quantity)
    {
        $this->quantity += $quantity;
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
        $this->updateQuantity($entry, 'add');

        return $this;
    }

    public function removeStockEntry(StockEntry $entry)
    {
        $this->updateQuantity($entry, 'remove');
        $this->stockEntries->removeElement($entry);
    }

    public function getDomain(): WineDomain
    {
        return $this->wine->getDomain();
    }
}
