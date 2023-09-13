<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class PointsLimitValidator extends ConstraintValidator
{
    public function validate($pokemon, Constraint $constraint): void
    {

        if (!$pokemon->isLegendary() 
            && ($pokemon->getHp() > 100 || $pokemon->getSpAtk() > 100 || $pokemon->getSpDef() > 100 || $pokemon->getAttack() > 100 || $pokemon->getDefense() > 100 || $pokemon->getSpeed() > 100)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

    }
}