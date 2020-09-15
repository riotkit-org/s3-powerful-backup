<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateBackupObjectCommand;
use App\Domain\Backup\WriteModel\BackupObject;
use App\Domain\Common\Service\WriteModelPersister;

class CreateBackupObjectHandler
{
    private WriteModelPersister $persister;

    public function __construct(WriteModelPersister $persister)
    {
        $this->persister = $persister;
    }

    public function __invoke(CreateBackupObjectCommand $command)
    {
        // @todo: Check if there is enough disk space for that declaration
        // future: Check if declaration size does not exceed user's quota

        $backup = BackupObject::fromArray($command->toArray(), $command->currentUser);
        $this->persister->persist($backup);
        $this->persister->flush();

        // todo: S3 bucket creation
        // todo: Generate access tokens
        // $eventBus->emitEvent(new BackupWasCreated($backup->id));
    }
}
