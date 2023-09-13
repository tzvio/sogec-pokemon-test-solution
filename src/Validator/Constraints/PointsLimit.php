<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PointsLimit extends Constraint
{
    public $message = 'Non legendary pokemons cannot have more than 100 points';
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}