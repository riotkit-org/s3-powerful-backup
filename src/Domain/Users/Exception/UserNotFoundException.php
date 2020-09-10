<?php declare(strict_types=1);

namespace App\Domain\Users\Exception;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Security\Errors;

class UserNotFoundException extends ValidationException
{
    public static function causeUserDoesNotExist(): UserNotFoundException
    {
        return static::fromErrors(
            [ValidationConstraintViolatedException::fromString(
                'email',
                Errors::ERR_MSG_USER_NOT_FOUND_BY_EMAIL,
                Errors::ERR_USER_NOT_FOUND_BY_EMAIL
            )],
            Errors::ERR_MSG_USER_NOT_FOUND_BY_EMAIL,
            Errors::ERR_USER_NOT_FOUND_BY_EMAIL,
        );
    }
}
