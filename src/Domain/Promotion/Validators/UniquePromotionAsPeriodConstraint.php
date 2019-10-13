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

use Symfony\Component\Validator\Constraint;

/**
 * Class UniquePromotionAsPeriodConstraint
 *
 * @Annotation
 */
class UniquePromotionAsPeriodConstraint extends Constraint
{
    public $message = 'Une promotion est déjà existante pour ce produit sur cette période.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
