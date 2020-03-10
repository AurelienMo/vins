<?php

declare(strict_types=1);

namespace App\Domain\Cart\AddItemToCart\Forms;

use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\Capacity;
use App\Entity\Product;

class ItemDTO
{
    protected $elements;

    /** @var Product */
    protected $wine;

    public static function createFromWineEntity(Product $wine, CartVO $vo)
    {
        $dto = new self();
        $elements = [];
        /** @var Capacity $capacity */
        foreach ($wine->getCapacities() as $capacity) {
            $productVoInCart = array_filter($vo->getProducts(), function (ProductVO $vo) use ($capacity) {
                return $vo->getCapacity()->getId() === $capacity->getId();
            });
            $elements[] = ElementDTO::createFromCapacityEntity(
                $capacity,
                current($productVoInCart) instanceof ProductVO ? current($productVoInCart) : null
            );
        }

        $dto->setElements($elements);
        $dto->setWine($wine);

        return $dto;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function setElements($elements): void
    {
        $this->elements = $elements;
    }

    public function getWine(): Product
    {
        return $this->wine;
    }

    public function setWine(Product $wine): void
    {
        $this->wine = $wine;
    }
}
