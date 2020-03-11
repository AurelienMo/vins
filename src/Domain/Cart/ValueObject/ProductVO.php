<?php

declare(strict_types=1);

namespace App\Domain\Cart\ValueObject;

use App\Entity\Capacity;
use App\Entity\Product;
use App\Entity\WineDomain;

class ProductVO implements ItemCartInterface
{
    /** @var Product */
    protected $product;

    /** @var WineDomain */
    protected $domain;

    /** @var Capacity */
    protected $capacity;

    /** @var int */
    protected $quantity;

    public function __construct(Product $product, WineDomain $domain, Capacity $capacity, int $quantity)
    {
        $this->product = $product;
        $this->capacity = $capacity;
        $this->quantity = $quantity;
        $this->domain = $domain;
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
        $this->quantity = $qty;
    }

    public function calculateSubTotalPrice()
    {
        return $this->capacity->getUnitPrice() * $this->quantity;
    }

    public function getDomain(): WineDomain
    {
        return $this->domain;
    }

    public function setDomain(WineDomain $domain): void
    {
        $this->domain = $domain;
    }
}
