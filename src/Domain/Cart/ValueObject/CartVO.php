<?php

declare(strict_types=1);

namespace App\Domain\Cart\ValueObject;

use App\Domain\Cart\LiveUpdateCart\InputItemObject;
use phpDocumentor\Reflection\Types\Array_;

class CartVO
{
    /** @var ProductVO[] */
    protected $products = [];

    public function addProduct(ProductVO $productVO)
    {
        /** @var array $existCapacity */
        $existCapacity = array_filter($this->products, function (ProductVO $vo) use ($productVO) {
            return $vo->getCapacity()->getId() === $productVO->getCapacity()->getId();
        });
        if (count($existCapacity) > 0) {
            current($existCapacity)->updateQuantity($productVO->getQuantity());
        } else {
            $this->products[] = $productVO;
        }
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function countElementsInCart()
    {
        $totalQty = 0;
        /** @var ProductVO $product */
        foreach ($this->products as $product) {
            $totalQty += $product->getQuantity();
        }

        return $totalQty;
    }

    public function removeProduct(ProductVO $productVO)
    {
        unset($this->products[array_search($productVO, $this->products)]);
    }

    public function getTotalPriceInCart()
    {
        $total = 0;
        /** @var ProductVO $product */
        foreach ($this->products as $product) {
            $total += $product->getQuantity() * $product->getCapacity()->getUnitPrice();
        }

        return $total;
    }
}
