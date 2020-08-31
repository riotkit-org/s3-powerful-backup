<?php

declare(strict_types=1);

namespace App\Backup\Entity;

/**
 * Entry: Group of multiple BackupObjectVersions acting together as SINGLE VERSION
 *
 * Example: Example-Application consists of BackupObjectVersion<Database v1> + BackupObjectVersion<Uploaded files v2>
 */
class BackupSequenceEntry
{
    public const STATE_OPEN   = 'open';
    public const STATE_CLOSED = 'closed';
    private const STATES = [self::STATE_OPEN, self::STATE_CLOSED];

    private string $state = self::STATE_OPEN;

    private string $id;

    private BackupSequence $backup;

    /**
     * Auto incrementing version field
     */
    private int $version;

    /**
     * @var BackupObjectVersion[]
     */
    private array $objectVersions;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $started;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $finished;
}
