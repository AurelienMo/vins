<?php

namespace App\Domain\Common\Constraints;

use App\Domain\Cart\AddItemToCart\Forms\ElementDTO;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotEnoughtStockValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /** @var ElementDTO $elementDTO */
        $elementDTO = $this->context->getObject();

        if ($value > $elementDTO->getCapacity()->getStock()->getQuantity()) {
            $this->context->buildViolation(
                sprintf('Produit victime de son succès, il reste %s produit(s) en stock', $elementDTO->getCapacity()->getStock()->getQuantity())
            )
                ->addViolation();
        }
    }
}
