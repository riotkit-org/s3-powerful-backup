<?php declare(strict_types=1);

namespace App\Application\Event\Handler;

use App\Application\Event\BackupWasCreatedEvent;
use App\Domain\Storage\Exception\StorageClaimError;
use App\Domain\Storage\Service\StorageManager;
use App\Domain\Storage\ValueObject\MaxAllVersionsSize;
use App\Domain\Storage\ValueObject\MaxOneVersionSize;
use App\Domain\Storage\ValueObject\MaxVersions;

/**
 * Creates buckets on S3 storage instance
 *
 * Asynchronous handler
 */
class CreateSpaceInStorageWhenBackupWasCreatedEventHandler
{
    private StorageManager $storageManager;

    public function __construct(StorageManager $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    public function __invoke(BackupWasCreatedEvent $event)
    {
        $this->validateDiskSpace($event->getMaxBucketSize(), $event->getMaxOneFileSize());
        $this->storageManager->createSpace(
            $event->backupObjectId,
            $event->getAllowedFileTypes(),
            MaxVersions::from($event->getMaxFiles()),
            MaxOneVersionSize::fromBytes($event->getMaxOneFileSize()),
            MaxAllVersionsSize::fromBytes($event->getMaxBucketSize())
        );
    }

    private function validateDiskSpace(int $bucketSize, int $oneVersionSize): void
    {
        $bucketSize = MaxAllVersionsSize::fromBytes($bucketSize);
        $oneVersionSize = MaxOneVersionSize::fromBytes($oneVersionSize);

        if (!$this->storageManager->checkThereIsSpaceForObject($bucketSize, $oneVersionSize)) {
            StorageClaimError::causeDeclaredSpaceExceedsCurrentFreeSpace();
        }
    }
}
