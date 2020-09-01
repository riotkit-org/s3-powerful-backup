<?php

declare(strict_types=1);

namespace App\Domain\Security;

use App\Domain\Backup\WriteModel\StorageLocation;

final class Roles
{
    public const ACTION_CREATE_USER = 'user.create';
    public const ACTION_CREATE_BACKUP = 'backup.create';

    public const ROLE_ADMIN = [
        self::ACTION_CREATE_USER,
        self::ACTION_CREATE_BACKUP
    ];
}
