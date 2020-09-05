<?php declare(strict_types=1);

namespace App\Domain\Security;

final class Errors
{
    public const ERR_USER_EXISTS     = 40001;
    public const ERR_MSG_USER_EXISTS = 'User already exists';

    public const ERR_USER_EMAIL_NOT_UNIQUE     = 40002;
    public const ERR_MSG_USER_EMAIL_NOT_UNIQUE = 'Selected e-mail address is already taken by someone. Maybe you need to recover your old account?';

    public const ERR_TEXT_FIELD_TOO_LONG       = 40003;
    public const ERR_MSG_TEXT_FIELD_TOO_LONG   = 'Maximum allowed characters exceeded';

    public const ERR_NON_UTF_CHARACTERS        = 40004;
    public const ERR_MSG_NON_UTF_CHARACTERS    = 'Field should contain only UTF-8 encoded characters';
}
