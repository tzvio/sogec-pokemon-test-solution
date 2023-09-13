<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[\Attribute]
final class AssertCanDelete extends Constraint
{
    public $message = 'Legendary pokemons are not allowed to be deleted!';
    public string $mode = 'strict';
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}