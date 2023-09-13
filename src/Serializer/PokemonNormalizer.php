<?php
namespace App\Serializer;

use App\Entity\Pokemon;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PokemonNormalizer implements DenormalizerInterface
{
    
    public function denormalize($data, $type, $format = null, array $context = []) : Pokemon 
    {
        $objectNormalizer = new ObjectNormalizer();
        $pokemon = $objectNormalizer->denormalize($data, $type, $format, $context);
        if (isset($data['Legendary'])) {
            $pokemon->setLegendary(filter_var($data['Legendary'], FILTER_VALIDATE_BOOLEAN));
        }
        if (isset($data['Sp. Atk'])) {
            $pokemon->setSpatk($data['Sp. Atk']);
        }
        if (isset($data['Sp. Def'])) {
            $pokemon->setSpdef($data['Sp. Def']);
        }
        return $pokemon;
    }


    public function supportsDenormalization($data, $type, $format = null, array $context = []) : bool
    {
        return $type === Pokemon::class;    
    }

    public function getSupportedTypes(?string $format): array
    {
            return [Pokemon::class => true];
    }

}