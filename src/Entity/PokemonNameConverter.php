<?php

namespace App\Entity;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class PokemonNameConverter implements NameConverterInterface
{

    private $propertyMapping = [
        '#' => 'id',
        'Sp. Atk' => 'spatk',
        'Sp. Def' => 'spdef'
    ];

    public function normalize($propertyName): string
    {
        return array_flip($this->propertyMapping)[$propertyName] ?? $propertyName;
    }

    public function denormalize($propertyName): string
    {
        return $this->propertyMapping[$propertyName] ?? $propertyName;
    }
}