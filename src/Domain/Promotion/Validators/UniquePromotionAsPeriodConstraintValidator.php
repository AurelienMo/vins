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

namespace App\Domain\Promotion\Validators;

use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UniquePromotionAsPeriodConstraintValidator
 */
class UniquePromotionAsPeriodConstraintValidator extends ConstraintValidator
{
    /** @var PromotionRepository */
    protected $promotionRepo;

    /**
     * UniquePromotionAsPeriodConstraintValidator constructor.
     *
     * @param PromotionRepository $promotionRepo
     */
    public function __construct(
        PromotionRepository $promotionRepo
    ) {
        $this->promotionRepo = $promotionRepo;
    }

    /**
     * @param Promotion  $value
     * @param Constraint $constraint
     */
    public function validate(
        $value,
        Constraint $constraint
    ) {
        $otherPromotionInProgress = $this->promotionRepo->isOtherPromotionInProgressAsSamePeriod(
            $value, $value->getProduct()->getId()
        );

        if ($otherPromotionInProgress) {
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}
