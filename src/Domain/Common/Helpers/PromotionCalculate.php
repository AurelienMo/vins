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

namespace App\Domain\Common\Helpers;

use App\Entity\OrderProductLine;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\TypePromotion;
use App\Repository\PromotionRepository;

/**
 * Class PromotionCalculate
 */
class PromotionCalculate
{
    /** @var PromotionRepository */
    protected $promoRepo;

    /**
     * PromotionCalculate constructor.
     *
     * @param PromotionRepository $promoRepo
     */
    public function __construct(
        PromotionRepository $promoRepo
    ) {
        $this->promoRepo = $promoRepo;
    }

    public function calculatePricePromotion(OrderProductLine $line): float
    {
        /** @var Promotion|null $promo */
        $promo = $this->promoRepo->findActivePromoByProduct($line->getWine());

        if (is_null($promo)) {
            return $line->getWine()->getPrice() * $line->getQuantity();
        }

        $promoName = $promo->getTypePromotion()->getName();
        $product = $line->getWine();

        $amount = 0;
        for ($i = 0; $i < $line->getQuantity(); $i++) {
            $result = $promoName === TypePromotion::TYPE_AMOUNT ?
                $product->getPrice() - $promo->getValue() :
                $product->getPrice() - ($product->getPrice() * $promo->getValue() / 100);

            $amount += $result;
        }

        return $amount;
    }
}
