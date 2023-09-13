<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\RemoveProcessor as DoctrineRemoveProcessor;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use ApiPlatform\Metadata\Operation;
use App\Validator\Constraints\AssertCanDelete;
use App\Validator\Constraints\CanBeDeleted;

class PokemonRemoveProcessor implements ProcessorInterface
{
    public function __construct(
        private DoctrineRemoveProcessor $doctrineProcessor,
        private ValidatorInterface $validator,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->validator->validate($data, ['groups' => ['deleteValidation']]);
        $this->doctrineProcessor->process($data, $operation, $uriVariables, $context);
    }
}