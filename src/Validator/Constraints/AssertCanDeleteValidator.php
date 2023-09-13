<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class AssertCanDeleteValidator extends ConstraintValidator
{
    public function validate($pokemon, Constraint $constraint): void
    {
        if ($pokemon->isLegendary()) { 
            $this->context->buildViolation($constraint->message)->addViolation();
        }

    }
}