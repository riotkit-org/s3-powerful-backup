<?php declare(strict_types=1);

namespace App\Domain\Users\Exception;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Common\Exception\DomainAssertionFailure;
use App\Domain\Security\Errors;

class UserCreationExceptionDomain extends DomainAssertionFailure
{
    public static function causeUserAlreadyExists(): UserCreationExceptionDomain
    {
        return static::fromErrors(
            [DomainConstraintViolatedException::fromString(
                'email', Errors::ERR_MSG_USER_EMAIL_NOT_UNIQUE, Errors::ERR_USER_EMAIL_NOT_UNIQUE
            )],
            Errors::ERR_MSG_USER_EXISTS,
            Errors::ERR_USER_EXISTS,
        );
    }
}
