<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\Security\Voter;

use CleverAge\EAVManager\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class ProductVoter extends Voter
{
    const OWNER = 'AKENEO_PRODUCT_OWNER';
    const NOT_OWNER = 'AKENEO_PRODUCT_NOT_OWNER';

    /** @var array */
    protected $ownerRoles;

    public function __construct(array $ownerRoles)
    {
        $this->ownerRoles = $ownerRoles;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::OWNER, self::NOT_OWNER]);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case self::OWNER:
                return $this->allGranted() || $this->isOwner($token->getUser());
            case self::NOT_OWNER:
                return !$this->allGranted() && !$this->isOwner($token->getUser());
        }
    }

    private function allGranted(): bool
    {
        return empty($this->ownerRoles);
    }

    private function isOwner(User $user): bool
    {
        return (bool) array_intersect($user->getRoles(), $this->ownerRoles);
    }
}
