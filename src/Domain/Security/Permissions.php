<?php

declare(strict_types=1);

namespace App\Domain\Security;

use App\Domain\Backup\WriteModel\BackupObject;
use App\Domain\Backup\WriteModel\StorageLocation;

final class Permissions
{
    public const STORAGE_UPLOAD = 'storage.upload';
    public const STORAGE_READ = 'storage.read';

    public const BACKUP_DEFINITION_READ   = 'backup-definition.read';
    public const BACKUP_DEFINITION_UPDATE = 'backup-definition.update';
    public const BACKUP_LIST_VERSIONS     = 'backup.list-versions';

    public const MAP = [
        StorageLocation::class => [
            self::STORAGE_READ,
            self::STORAGE_UPLOAD
        ],

        BackupObject::class => [
            self::BACKUP_DEFINITION_READ,
            self::BACKUP_DEFINITION_UPDATE,
            self::BACKUP_LIST_VERSIONS
        ]
    ];
}
