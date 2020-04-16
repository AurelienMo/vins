<?php

declare(strict_types=1);

namespace App\Domain\Common\Twig;

use App\Domain\Common\Helpers\PromotionCalculate;
use App\Entity\Capacity;
use App\Repository\PromotionRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ApplyPromotionExtension extends AbstractExtension
{
    /** @var PromotionRepository */
    protected $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('applyPromo', [$this, 'applyPromo'])
        ];
    }

    public function applyPromo(Capacity $capacity)
    {
        $promotion = $this->promotionRepository->findActivePromoByProduct($capacity->getWine());

        if (is_null($promotion)) {
            return $capacity->getUnitPrice();
        }

        return PromotionCalculate::calcultePromoForProduct($capacity, $promotion);
    }
}
