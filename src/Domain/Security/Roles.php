<?php

declare(strict_types=1);

namespace App\Domain\Security;

use App\Domain\Security\Exception\InvalidRoleError;
use ReflectionClass;
use function get_called_class;

final class Roles
{
    private static ?array $cache = null;

    // users
    public const ROLE_ACTION_CREATE_USER       = 'ROLE_ACTION_CREATE_USER';
    public const ROLE_ACTION_USER_ASSIGN_ROLES = 'ROLE_ACTION_USER_ASSIGN_ROLES';

    // backups
    public const ROLE_ACTION_CREATE_BACKUP_OBJECTS = 'ROLE_ACTION_CREATE_BACKUP_OBJECTS';

    public const ROLE_USER = [];
    public const ROLE_ADMIN = [
        self::ROLE_ACTION_CREATE_USER,
        self::ROLE_ACTION_USER_ASSIGN_ROLES,
        self::ROLE_ACTION_CREATE_BACKUP_OBJECTS
    ];

    /**
     * Lists all role names
     *
     * @return string[]
     */
    public static function getRoleNames(): array
    {
        if (static::$cache === null) {
            $ref = new ReflectionClass(get_called_class());

            static::$cache = array_keys(array_filter(
                $ref->getConstants(),
                (fn($name) => strpos($name, 'ROLE_') === 0 || strpos($name, 'ACTION_') === 0),
                ARRAY_FILTER_USE_KEY
            ));
        }

        return static::$cache;
    }

    /**
     * @param string $roleName
     * @return string[]
     *
     * @throws InvalidRoleError
     */
    public static function expandRole(string $roleName): array
    {
        $role = @constant('static::' . $roleName);

        if (is_array($role)) {
            return array_merge([$roleName], $role);
        }

        if ($role === null) {
            throw new InvalidRoleError($roleName);
        }

        return [$roleName];
    }

    /**
     * @param array $roles
     *
     * @return array
     *
     * @throws InvalidRoleError
     */
    public static function expandRoles(array $roles): array
    {
        $expanded = [];

        foreach ($roles as $role) {
            $expanded[] = static::expandRole($role);
        }

        return array_merge(...$expanded);
    }
}
