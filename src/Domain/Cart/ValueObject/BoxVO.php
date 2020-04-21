<?php

namespace App\Domain\Cart\ValueObject;

use App\Entity\BoxWine;

class BoxVO
{
    /** @var BoxWine */
    protected $box;

    /** @var int */
    protected $quantity;

    /** @var float */
    protected $unitPrice;

    public function __construct(BoxWine $box, int $quantity, float $unitPrice)
    {
        $this->box = $box;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return BoxWine
     */
    public function getBox(): BoxWine
    {
        return $this->box;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function updateQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function calculateSubTotalPrice()
    {
        return $this->quantity * $this->unitPrice;
    }
}
