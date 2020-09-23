<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateBackupObjectCommand;
use App\Application\Event\BackupIsBeingCreatedEvent;
use App\Application\Event\BackupWasCreatedEvent;
use App\Domain\Backup\WriteModel\Author;
use App\Domain\Backup\WriteModel\BackupObject;
use App\Domain\Common\Service\EventBusInterface;
use App\Domain\Common\Service\WriteModelPersister;

/**
 * Creates a
 */
class CreateBackupObjectHandler
{
    private WriteModelPersister $persister;
    private EventBusInterface $eventBus;

    public function __construct(WriteModelPersister $persister, EventBusInterface $eventBus)
    {
        $this->persister = $persister;
        $this->eventBus  = $eventBus;
    }

    public function __invoke(CreateBackupObjectCommand $command)
    {
        // throw validation event
        $this->eventBus->emit(new BackupIsBeingCreatedEvent($command->maxAllVersionsSize, $command->maxOneVersionSize));

        // create domain object, validated by domain itself
        $backup = BackupObject::fromArray($command->toArray(), $this->createContextUser($command->authorEmail));

        $this->persister->persist($backup);
        $this->persister->flush();

        // summary event
        $this->eventBus->emit(new BackupWasCreatedEvent(
            $backup->getId(),
            $backup->getAllowedFileTypes()->getValue(),
            (int) $backup->getMaxVersions()->getValue(),
            (int) $backup->getMaxOneVersionSize()->getValue(),
            (int) $backup->getMaxAllVersionsSize()->getValue()
        ));
    }

    /**
     * @param string $email
     *
     * @return Author
     */
    protected function createContextUser(string $email): Author
    {
        /**
         * @var Author $user
         */
        $user = $this->persister->findOneBy(['email' => $email], Author::class);

        return $user;
    }
}
