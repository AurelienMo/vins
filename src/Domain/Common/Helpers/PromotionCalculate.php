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

    public function calculatePricePromotion(Product $product): float
    {
        /** @var Promotion|null $promo */
        $promo = $this->promoRepo->findActivePromoByProduct($product);

        if (is_null($promo)) {
            return $product->getPrice();
        }

        return (float) $promo->getTypePromotion()->getName() === TypePromotion::TYPE_AMOUNT ?
            $product->getPrice() - $promo->getValue() :
            $product->getPrice() - ($product->getPrice() * $promo->getValue() / 100);
    }
}
