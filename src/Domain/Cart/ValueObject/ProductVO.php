<?php

declare(strict_types=1);

namespace App\Domain\Cart\ValueObject;

use App\Entity\Capacity;
use App\Entity\Product;

class ProductVO implements ItemCartInterface
{
    /** @var Product */
    protected $product;

    /** @var Capacity */
    protected $capacity;

    /** @var int */
    protected $quantity;

    public function __construct(Product $product, Capacity $capacity, int $quantity)
    {
        $this->product = $product;
        $this->capacity = $capacity;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getCapacity(): Capacity
    {
        return $this->capacity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function updateQuantity(int $qty): void
    {
        $this->quantity += $qty;
    }
}
