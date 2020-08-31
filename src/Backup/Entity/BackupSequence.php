<?php

declare(strict_types=1);

namespace App\Backup\Entity;

/**
 * Definition: Group of multiple BackupObjects acting together as SINGLE VERSION
 * Transactional entity.
 *
 * Example: Example-Application consists of BackupObject<Database> and BackupObject<Uploaded files>
 */
class BackupSequence
{
    private string $id;

    private string $description;

    /**
     * @var BackupObject[]
     */
    private array $objects;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $created;
}
