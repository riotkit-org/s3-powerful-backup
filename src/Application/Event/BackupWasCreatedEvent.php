<?php declare(strict_types=1);

namespace App\Application\Event;

class BackupWasCreatedEvent
{
    public string $backupObjectId;
    private array $allowedFileTypes;
    private int   $maxFiles;
    private int   $maxOneFileSize;
    private int   $maxBucketSize;

    public function __construct(string $backupObjectId, array $allowedFileTypes, int $maxFiles, int $maxOneFileSize, int $maxBucketSize)
    {
        $this->backupObjectId   = $backupObjectId;
        $this->allowedFileTypes = $allowedFileTypes;
        $this->maxFiles         = $maxFiles;
        $this->maxOneFileSize   = $maxOneFileSize;
        $this->maxBucketSize    = $maxBucketSize;
    }

    public function getMaxBucketSize(): int
    {
        return $this->maxBucketSize;
    }

    public function getMaxOneFileSize(): int
    {
        return $this->maxOneFileSize;
    }

    public function getAllowedFileTypes(): array
    {
        return $this->allowedFileTypes;
    }

    public function getMaxFiles(): int
    {
        return $this->maxFiles;
    }
}
