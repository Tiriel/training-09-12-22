<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BookVoter extends Voter
{
    public const EDIT = 'book.edit';
    private AuthorizationCheckerInterface $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, [self::EDIT])
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }
        assert($subject instanceof Book);

        switch ($attribute) {
            case self::EDIT:
                if ($user === $subject->getAddedBy() || $this->checker->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
            default:
                return false;
        }
        return false;
    }
}
