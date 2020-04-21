<?php

namespace App\Domain\Common\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotEnoughtStock extends Constraint
{
    public $message = "stock insuffisant";
}
