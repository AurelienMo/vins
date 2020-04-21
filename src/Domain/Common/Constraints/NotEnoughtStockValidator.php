<?php

namespace App\Domain\Common\Constraints;

use App\Domain\Cart\AddItemToCart\Forms\ElementDTO;
use App\Domain\Cart\Helpers\CartHelper;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\Capacity;
use App\Entity\Product;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotEnoughtStockValidator extends ConstraintValidator
{
    /** @var CartHelper */
    protected $cartHelper;

    public function __construct(CartHelper $cartHelper)
    {
        $this->cartHelper = $cartHelper;
    }

    public function validate($value, Constraint $constraint)
    {
        /** @var ElementDTO $elementDTO */
        $elementDTO = $this->context->getObject();
        $cart = $this->cartHelper->getCartForCurrentUser();
        $productInCart = array_filter($cart->getProducts(), function (ProductVO $vo) use ($elementDTO) {
            return $vo->getCapacity()->getId() === $elementDTO->getCapacity()->getId();
        });
        $hasStock = true;
        $qtyToRest = $elementDTO->getCapacity()->getStock()->getQuantity();
        if (count($productInCart) > 0 &&
            $value > ($this->calculateRestStock($qtyToRest, current($productInCart)->getQuantity()))
        ) {
            $qtyToRest -= current($productInCart)->getQuantity();
            $hasStock = false;
        }

        foreach ($cart->getBoxs() as $box) {
            $productCartBox = array_filter($box->getBox()->getWines()->toArray(), function (Capacity $capacity) use ($elementDTO) {
                return $capacity->getId() === $elementDTO->getCapacity()->getId();
            });
            if (count($productCartBox) > 0 &&
                $value > ($this->calculateRestStock($qtyToRest, 1))
            ) {
                $qtyToRest = $qtyToRest - 1 < 0 ? 0 : $qtyToRest - 1;
                $hasStock = false;
            }
        }

        if (!$hasStock) {
            $this->context->buildViolation(
                sprintf('Produit victime de son succès, il reste %s produit(s) en stock', $qtyToRest)
            )
                ->addViolation();
        }
    }

    private function calculateRestStock(int $actualStock, int $quantityToDescrease)
    {
        return $actualStock - $quantityToDescrease;
    }
}
