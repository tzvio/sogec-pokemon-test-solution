<?php

namespace App\Security\Voter;

use App\Entity\Pokemon;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LegendaryPokemonVoter extends Voter
{
    public const VIEW_LEGENDARY = 'VIEW_LEGENDARY';
    public function __construct(
    ) {
    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        return ($attribute == self::VIEW_LEGENDARY && $subject instanceof Pokemon);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        return true;
    }
}
