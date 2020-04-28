<?php

declare(strict_types=1);

namespace App\Domain\Cart\ValueObject;

use App\Domain\Cart\Delivery\Forms\DeliveryDTO;
use App\Domain\Cart\LiveUpdateCart\InputItemObject;
use phpDocumentor\Reflection\Types\Array_;

class CartVO
{
    /** @var ProductVO[] */
    protected $products = [];

    /** @var BoxVO[] */
    protected $boxs = [];

    /** @var DeliveryDTO|null */
    protected $deliveryInformation;

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

        foreach ($this->boxs as $box) {
            $totalQty += $box->getQuantity();
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
            $price = !\is_null($product->getPricePromo()) ?
                $product->getPricePromo() * $product->getQuantity() :
                $product->getUnitPrice() * $product->getQuantity();
            $total += $price;
        }
        foreach ($this->boxs as $box) {
            $total += $box->getUnitPrice() * $box->getQuantity();
        }

        return $total;
    }

    public function affectDelivery(DeliveryDTO $dto)
    {
        $this->deliveryInformation = $dto;
    }

    public function getTotalPriceWithDelivery()
    {
        if (!$this->getDeliveryInformation() instanceof DeliveryDTO) {
            return $this->getTotalPriceInCart();
        }

        $priceDelivery = null;
        switch ($this->deliveryInformation->getTypeDelivery()) {
            case 'free':
                $priceDelivery = 0;
                break;
            case 'basic':
                $priceDelivery = 4;
                break;
            case 'express':
                $priceDelivery = 6;
                break;
        }

        return $this->getTotalPriceInCart() + $priceDelivery;
    }

    public function getDeliveryInformation(): ?DeliveryDTO
    {
        return $this->deliveryInformation;
    }

    public function getBoxs()
    {
        return $this->boxs;
    }

    public function removeBox(BoxVO $boxVo)
    {
        unset($this->boxs[array_search($boxVo, $this->boxs)]);
    }

    public function addBox(BoxVO $boxVo)
    {
        /** @var array $existCapacity */
        $existBox = array_filter($this->boxs, function (BoxVO $vo) use ($boxVo) {
            return $vo->getBox()->getId() === $boxVo->getBox()->getId();
        });
        if (count($existBox) > 0) {
            current($existBox)->updateQuantity($boxVo->getQuantity());
        } else {
            $this->boxs[] = $boxVo;
        }
    }
}
