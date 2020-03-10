<?php

declare(strict_types=1);

namespace App\Domain\Cart\AddItemToCart\Forms;

use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\Capacity;
use App\Entity\Product;

class ElementDTO
{
    /** @var Capacity */
    protected $capacity;

    /** @var int|null */
    protected $quantity;

    public static function createFromCapacityEntity(Capacity $capacity, ?ProductVO $vo)
    {
        $dto = new self();
        $dto->setCapacity($capacity);
        $dto->setQuantity(!is_null($vo) ? $vo->getQuantity() : 0);

        return $dto;
    }

    public function getCapacity(): Capacity
    {
        return $this->capacity;
    }

    public function setCapacity(Capacity $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
