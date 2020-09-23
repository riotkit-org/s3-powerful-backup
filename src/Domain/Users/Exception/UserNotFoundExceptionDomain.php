<?php declare(strict_types=1);

namespace App\Domain\Users\Exception;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Common\Exception\DomainAssertionFailure;
use App\Domain\Security\Errors;

class UserNotFoundExceptionDomain extends DomainAssertionFailure
{
    public static function causeUserDoesNotExist(): UserNotFoundExceptionDomain
    {
        return static::fromErrors(
            [DomainConstraintViolatedException::fromString(
                'email',
                Errors::ERR_MSG_USER_NOT_FOUND_BY_EMAIL,
                Errors::ERR_USER_NOT_FOUND_BY_EMAIL
            )],
            Errors::ERR_MSG_USER_NOT_FOUND_BY_EMAIL,
            Errors::ERR_USER_NOT_FOUND_BY_EMAIL,
        );
    }
}
