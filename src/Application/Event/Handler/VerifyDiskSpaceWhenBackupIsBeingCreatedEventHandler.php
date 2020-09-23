<?php declare(strict_types=1);

namespace App\Application\Event\Handler;

use App\Application\Event\BackupIsBeingCreatedEvent;
use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Common\Exception\DomainAssertionFailure;
use App\Domain\Storage\Exception\StorageClaimError;
use App\Domain\Storage\Service\StorageManager;
use App\Domain\Storage\ValueObject\MaxAllVersionsSize;
use App\Domain\Storage\ValueObject\MaxOneVersionSize;

class VerifyDiskSpaceWhenBackupIsBeingCreatedEventHandler
{
    private StorageManager $storageManager;

    public function __construct(StorageManager $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * @param BackupIsBeingCreatedEvent $event
     *
     * @throws DomainAssertionFailure
     * @throws DomainConstraintViolatedException
     */
    public function __invoke(BackupIsBeingCreatedEvent $event)
    {
        $bucketSize = MaxAllVersionsSize::fromHumanReadableFormat($event->maxAllVersionsSize);
        $oneVersionSize = MaxOneVersionSize::fromHumanReadableFormat($event->oneVersionSize);

        if (!$this->storageManager->checkThereIsSpaceForObject($bucketSize, $oneVersionSize)) {
            StorageClaimError::causeDeclaredSpaceExceedsCurrentFreeSpace();
        }
    }
}
