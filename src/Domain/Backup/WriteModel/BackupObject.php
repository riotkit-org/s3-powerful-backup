<?php

declare(strict_types=1);

namespace App\Domain\Backup\WriteModel;

class BackupObject
{
    private string $id;

    private string $name;

    private string $description;

    /**
     * @var string[]
     */
    private array $allowedFileTypes;

    /**
     * @var int Maximum amount of versions
     */
    private int $maxVersions;

    private int $maxOneVersionSize;

    private int $maxAllVersionsSize;

    private StorageLocation $location;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $created;
}
