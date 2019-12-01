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
class Stock extends AbstractEntity implements
    UpdatableInterface
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
     * @var StockEntry[]|Collection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\StockEntry", mappedBy="stock", cascade={"persist", "remove"}, orphanRemoval=true
     *     )
     */
    protected $stockEntries;

    /**
     * @var Capacity
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Capacity", inversedBy="stock", cascade={"remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="amo_capacity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $capacity;

    public function __construct()
    {
        $this->stockEntries = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function updateQuantityAfterOrder(int $quantity)
    {
        $this->quantity += $quantity;
    }

    public function __toString()
    {
        return sprintf(
            '%s - %s - %s',
            $this->capacity->getWine(),
            $this->capacity->getType(),
            $this->capacity->getQuantity()
        );
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
        $this->updateQuantity(
            $entry,
            'add'
        );

        return $this;
    }

    public function updateQuantity(
        StockEntry $entry,
        string $type
    ): void {
        switch ($type) {
            case 'add':
                $this->quantity += $entry->getQuantity();
                break;
            case 'remove':
                $this->quantity -= $entry->getQuantity();
                break;
        }
    }

    public function removeStockEntry(StockEntry $entry)
    {
        $this->updateQuantity(
            $entry,
            'remove'
        );
        $this->stockEntries->removeElement($entry);
    }

    public function getDomain(): WineDomain
    {
        return $this->capacity->getWine()->getDomain();
    }

    /**
     * @return Capacity
     */
    public function getCapacity(): Capacity
    {
        return $this->capacity;
    }

    /**
     * @param Capacity $capacity
     */
    public function setCapacity(Capacity $capacity): void
    {
        $this->capacity = $capacity;
    }
}
