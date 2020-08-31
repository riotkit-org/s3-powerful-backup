<?php

declare(strict_types=1);

namespace App\Backup\Entity;

class BackupObjectVersion
{
    /**
     * @var BackupObject Parent definition
     */
    private BackupObject $backup;

    /**
     * @var int Version eg. 1 -> 2 -> 3 -> 4
     */
    private int $version;

    private string $filename;

    private int $filesize;

    private string $fileMime;

    /**
     * @var \DateTimeImmutable Upload time
     */
    private \DateTimeImmutable $created;
}
