<?php

declare(strict_types=1);

namespace App\Domain\Security;

use ReflectionClass;
use function get_called_class;

final class Roles
{
    public const ACTION_CREATE_USER       = 'ACTION_USER_CREATE';
    public const ACTION_USER_ASSIGN_ROLES = 'ACTION_USER_ASSIGN_ROLES';

    public const ACTION_CREATE_BACKUP = 'ACTION_BACKUP_CREATE';

    public const ROLE_ADMIN = [
        self::ACTION_CREATE_USER,
        self::ACTION_USER_ASSIGN_ROLES,

        self::ACTION_CREATE_BACKUP
    ];

    /**
     * Lists all role names
     *
     * @return string[]
     */
    public static function getRoleNames(): array
    {
        $ref = new ReflectionClass(get_called_class());

        return array_keys(array_filter(
            $ref->getConstants(),
            (fn($name) => strpos($name, 'ROLE_') === 0 || strpos($name, 'ACTION_') === 0),
            ARRAY_FILTER_USE_KEY
        ));
    }
}
