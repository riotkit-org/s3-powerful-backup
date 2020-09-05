<?php declare(strict_types=1);

namespace App\Domain\Users\Exception;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Security\Errors;

class UserCreationException extends ValidationException
{
    public static function causeUserAlreadyExists(): UserCreationException
    {
        return static::fromErrors(
            [ValidationConstraintViolatedException::fromString(
                'email', Errors::ERR_MSG_USER_EMAIL_NOT_UNIQUE, Errors::ERR_USER_EMAIL_NOT_UNIQUE
            )],
            Errors::ERR_MSG_USER_EXISTS,
            Errors::ERR_USER_EXISTS,
        );
    }
}
