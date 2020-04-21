<?php

namespace App\Domain\Common\Twig;

use App\Domain\Cart\Helpers\CartHelper;
use App\Domain\Cart\ValueObject\BoxVO;
use App\Entity\BoxWine;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CheckBoxInCard extends AbstractExtension
{
    /** @var CartHelper */
    protected $cardHelper;

    public function __construct(CartHelper $cardHelper)
    {
        $this->cardHelper = $cardHelper;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('checkIsBoxInCart', [$this, 'checkIsBoxInCart'])
        ];
    }

    public function checkIsBoxInCart(BoxWine $boxWine)
    {
        $boxsInCart = $this->cardHelper->getCartForCurrentUser()->getBoxs();
        $existBox = array_filter($boxsInCart, function (BoxVO $vo) use ($boxWine) {
            return $vo->getBox()->getId() === $boxWine->getId();
        });

        return count($existBox) > 0 ? current($existBox)->getQuantity() : 0;
    }
}
